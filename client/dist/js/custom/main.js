///////////-------Begin Services

//Reusable function to format datetime
function formatDateTime(datetime) {
  let fancyDateTime;
  if (datetime != "0000-00-00 00:00:00") {
    fancyDateTime = momentDatetime(datetime);
  } else {
    fancyDateTime = "";
  }
  return fancyDateTime;
}


function service_list() {
  //add a loading spinner to list body
  $("#service_list").html(
    '<div class="row pt-5 pb-5">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6 d-flex justify-content-center align-items-center">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );

  
  let where_ = $("#_where_").val();
  if (!where_) {
    where_ = "id > 0";
  }

  let dir = $("#_dir_").val();
  if (!dir) {
    dir = "ASC";
  }

  let orderby = $("#_orderby_").val();
  if (!orderby) {
    orderby = "next_run_datetime";
  }

  let offset = $("#_offset_").val();
  if (!offset) {
    offset = 0;
  }
  let rpp = $("#_rpp_").val();
  if (!rpp) {
    rpp = 10;
  }

  let search = $("#search_").val();
  if (!search) {
    search = "";
  }

  let query =
    "?where_=" +
    where_ +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp +
    "&search=" +
    search;

  //default jsonbody
  let jso = {};
  let totals = 0;

  crudaction(jso, "/services/read_all.php" + query, "GET", function (feed) {
    if (feed.success) {
      let data = feed["data"];
      let objLength = data.length;

      totals = feed.count;
      $("#services_total").html(totals);

      $('#_alltotal_').val(totals);

      let row = "";
      let count = 0;
      for (let i = 0; i < objLength; i++) {
        let id = data[i].id;
        let service_title = data[i].service_title;
        let company_name = data[i].company_name;
        let last_run_datetime = data[i].last_run_datetime;
        let next_run_datetime = data[i].next_run_datetime;
        let unit = data[i].unit;
        let frequency = data[i].frequency;
        let repeated = data[i].repeated;
        let status = data[i].status;

        let statusView = "";
        let actionView = "";

        //last run date and time view
        last_run_datetime = sliceDatetime(last_run_datetime);
        next_run_datetime = sliceDatetime(next_run_datetime);

        //Usage example
        let fancyNextRunDatetime = formatDateTime(next_run_datetime);
        if (next_run_datetime == "0000-00-00 00:00:00") {
          next_run_datetime = "N/A";
        }

        let fancyLastRunDatetime = formatDateTime(last_run_datetime);
        if (last_run_datetime == "0000-00-00 00:00:00") {
          last_run_datetime = "N/A";
        }

        //status view
        if (status == 1) {
          statusView =
            '<span class="badge badge-pill badge-success">Active</span>';
          actionView =
            '<span><a href="javascript:void(0)" onclick="deleteService(' +
            id +
            ')"><span style="color:white;" class="btn btn-sm btn-danger fa fa-times"> Block</span></a></span>';
        } else {
          statusView =
            '<span class="badge badge-pill badge-danger">Blocked</span>';
          actionView =
            '<span><a href="javascript:void(0)" onclick="activateService(' +
            id +
            ')"><span style="color:white;" class="btn btn-primary"> Activate</span></a></span>';
        }

        count++;
        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          service_title +
          "<br><i><small><b class='text-muted'>Company</b>: <span>" +
          company_name +
          "</span></small></i>" +
          "</td>\n" +
          "<td>" +
          timeConversion12Hours(last_run_datetime) +
          '<br><span" class="badge badge-secondary">' +
          fancyLastRunDatetime +
          "</span>" +
          "</td>\n" +
          "<td>" +
          timeConversion12Hours(next_run_datetime) +
          '<br><span" class="badge badge-secondary">' +
          fancyNextRunDatetime +
          "</span>" +
          "</td>\n" +
          "<td>" +
          unit +
          "</td>\n" +
          "<td>" +
          frequency +
          "</td>\n" +
          "<td>" +
          repeated +
          "</td>\n" +
          "<td>" +
          statusView +
          "</td>\n" +
          "<td class='action_btns'>" +
          '<span><a href="?service=' +
          id +
          '"><span class="btn btn-sm btn-default fa fa-eye"> View</span></a></span>&nbsp;&nbsp;' +
          '<span><a href="?service-add-edit=' +
          id +
          '"><span style="color:white;" class="btn btn-sm btn-warning fa fa-pencil"> Update</span></a></span>&nbsp;&nbsp;' +
          actionView +
          "</td>\n" +
          "</tr>";
      }
      $("#service_list").html(row);
    } else {
      //////-------No functionalities found
      //Update the input  value for total records
      $('#_alltotal_').val(totals);

      $("#service_list").html(
        "<tr><td colspan='8'><i>No Records Found</i></td></tr>"
      );
    }
  });
  //call page refactor after a short while
  setTimeout(function () {
    pager_refactor();
  }, 500);
}

//customer list filters
function service_filters() {
  let service_order = $('#service_order').val();
  let company_name = parseInt($('#sel_company').val());

  let wher = "id > 0";
  $('#_dir_').val(service_order);

  if (company_name > 0) {
      wher += " AND company_name=" + company_name;
  }

  //console.log("filt " + wher);

  if (wher) {
      $('#_where_').val(wher);
      $('#_offset_').val(0);

      pager_home();
  } else {
      $('#_where_').val(" status > -1");
      $('#_offset_').val(0);
  }
}


//friendly datetime formatter
function momentDatetime(targetdt) {
  console.log("MOMENT TARGET DATE => ", targetdt);
  return moment(targetdt).fromNow();
}

function isExecuted(isexc) {
  let executedView;
  if (isexc == "Yes") {
    executedView = '<span class="badge badge-pill badge-success">Yes</span>';
  } else {
    executedView = '<span class="badge badge-pill badge-primary">No</span>';
  }
  return executedView;
}

function getServiceById() {
  //show loader
  $("#service-details_table").html(
    '<div class="row d-flex justify-content-center align-items-center">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );

  $("#service-update_btn").html(
    '<div class="row d-flex justify-content-center align-items-center">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );


  let service_id = $("#service_").val();

  let jso = {};
  let query = "?id=" + service_id;

  crudaction(jso, "/services/read_one.php" + query, "GET", function (feed) {
    let data = feed["data"];

    console.log("FEED => ", data)

    if (data) {
      let {
        id,
        service_title,
        company_name,
        service_address,
        last_run_datetime,
        next_run_datetime,
        unit,
        frequency,
        status,
        added_at,
        added_by
      } = data

      let statusView = "";

      last_run_datetime = sliceDatetime(last_run_datetime);
      next_run_datetime = sliceDatetime(next_run_datetime);

      let fancyNextRunDatetime;
      fancyNextRunDatetime = momentDatetime(next_run_datetime);

      let fancyLastRunDatetime;
      if (last_run_datetime != "0000-00-00 00:00:00") {
        console.log("ABOUT TO FANCY => ", fancyLastRunDatetime)
        fancyLastRunDatetime = momentDatetime(last_run_datetime);
      } else {
        fancyLastRunDatetime = "";
      }
      //console.log("Human friendly datetime => ", momentDatetime("2022-03-17 06:00"));
      if (last_run_datetime == "0000-00-00 00:00:00") {
        last_run_datetime = "N/A";
      }

      if (status == 1) {
        statusView =
          '<span class="badge badge-pill badge-success">Active</span>';
        actionView =
          '<span><a href="javascript:void(0)" onclick="deleteService(' +
          id +
          ')"><span style="color:white;" class="btn btn-danger fa fa-times"> Delete</span></a></span>';
      } else {
        statusView =
          '<span class="badge badge-pill badge-danger">Deleted</span>';
        actionView =
          '<span><a href="javascript:void(0)" onclick="activateService(' +
          id +
          ')"><span style="color:white;" class="btn btn-primary"> Activate</span></a></span>';
      }

      $(".service_name").html("Details");

      const t_rows =
        "<tr>\n" +
        "<td>ID</td>\n" +
        "<td>" +
        id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Service Title</td>\n" +
        "<td>" +
        service_title +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Address</td>\n" +
        "<td style='max-width:100px; word-oveflow: break-word; word-wrap: break-word;'>" +
        service_address +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Company Name</td>\n" +
        "<td>" +
        company_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Last Run</td>\n" +
        "<td>" +
        timeConversion12Hours(sliceDatetime(last_run_datetime)) +
        '<br><span" class="badge badge-secondary">' +
        fancyLastRunDatetime +
        "</span>" +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Next Run</td>\n" +
        "<td>" +
        timeConversion12Hours(sliceDatetime(next_run_datetime)) +
        '<br><span" class="badge badge-secondary">' +
        fancyNextRunDatetime +
        "</span>" +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Unit</td>\n" +
        "<td>" +
        unit +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Frequency</td>\n" +
        "<td>" +
        frequency +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        sliceDatetime(added_at) +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>status</td>\n" +
        "<td>" +
        statusView +
        "</td>\n" +
        "</tr>";

        $("#service-details_table").html(t_rows)
  
        const service_update_btn = "<tr>\n" +
        '<td><a href="services?service-add-edit=' +
        id +
        '" class="btn btn-warning btn-block btn-md grid-width-8"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";

      $("#service-update_btn").html(service_update_btn);
    } else {
      //////-------No services found
      $("#service-details_table").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );

      $("#service-update_btn").html('');
    }
  });
}

function getLogsByServiceId() {
  //show loader
  $("#log-list").html(
    '<div class="row d-flex justify-content-center align-items-center">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );

  let service_id = $("#service_").val();
  let orderby = "logged_date";
  let dir = "DESC";
  let offset = 0;
  let rpp = 25;
  let page_no = 1;
  let jso = {};

  let query =
    "?service_id=" +
    service_id +
    "&page_no=" +
    page_no +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(
    jso,
    "/logs/logs_by_serviceid.php" + query,
    "GET",
    function (feed) {
      if (feed.success) {
        let data = feed["data"];
        let objLength = data.length;
        let row = "";

        for (let i = 0; i < objLength; i++) {
          let log = data[i].log;
          let logView = '<span class="text-green">' + log + "</span>";
          let logged_date = data[i].logged_date;
          logged_date = sliceDatetime(logged_date);

          if (log.indexOf("Success") === -1) {
            logView = '<span class="text-danger">' + log + "</span>";
          }

          let fancyloggedDate;
          fancyloggedDate = momentDatetime(logged_date);

          row +=
            "<tr><td>" +
            logView +
            "</td><td>[" +
            timeConversion12Hours(logged_date) +
            "] " +
            fancyloggedDate +
            "</td></tr>";
        }
        $("#log_list").html(row);
      } else {
        //////-------No functionalities found
        $("#log_list").html(
          "<tr><td colspan='2'><i>No Records Found</i></td></tr>"
        );
      }
    }
  );
}


function timeConversion24Hours(dt) {
  //slice time for conversion
  let ot = dt.slice(11, 21);
  let mt = dt.slice(11, 21);

  let lastTwo = mt.slice(-2);

  let firstTwo = mt.slice(0, 2);
  let intFirstTwo = parseInt(firstTwo);

  if (lastTwo == "PM" && intFirstTwo < 12) {
      intFirstTwo += 12;
      mt = mt.replace(firstTwo, intFirstTwo).replace(lastTwo, "");
  } else if (lastTwo == "PM" && intFirstTwo >= 12) {
      mt = mt.replace(lastTwo, "");
  } else if (lastTwo == "AM" && intFirstTwo < 12) {
      mt = mt.replace(lastTwo, "");
  } else {
      if (lastTwo == "AM" && intFirstTwo == 12) {
          intFirstTwo -= 12;
          mt = mt.replace(lastTwo, "").replace(firstTwo, "0" + intFirstTwo);
      }
  }

  dt = dt.replace(ot, mt);
  return dt;
}


function timeConversion12Hours(dt) {
  //slice time for conversion
  let ot = dt.slice(11, 21);
  let mt = dt.slice(11, 21);

  /* let lastTwo = mt.slice(-2); */
  let firstTwo = mt.slice(0, 2);
  let intFirstTwo = parseInt(firstTwo);
  let timeZeroIndex = mt.slice(0, 1);

  /* console.log("ZERO INDEX VALUE IS => ", timeZeroIndex); */

  if (intFirstTwo == "00") {
    intFirstTwo += 12;
    mt = mt.replace(firstTwo, intFirstTwo) + "AM";
  } else if (intFirstTwo < 12 && intFirstTwo != "00" && timeZeroIndex != 0) {
    mt = mt + "AM";
  } else if (intFirstTwo < 12 && intFirstTwo != "00" && timeZeroIndex == 0) {
    mt = mt.replace("0", "") + "AM";
  } else if (intFirstTwo > 12) {
    intFirstTwo -= 12;
    mt = mt.replace(firstTwo, intFirstTwo) + "PM";
  } else {
    if (intFirstTwo == 12) {
      mt = mt + "PM";
    }
  }

  dt = dt.replace(ot, mt);
  return dt;
}


function sliceDatetime(dt) {
  return dt?.slice(0, 19);
}

function deleteService(service_id) {
  const answer = window.confirm("Are you sure?");
  if (!answer) return;
  const service_creator_editor = parseInt($("#service_creator_editor_id").val())
  let jso = { service_id, service_creator_editor };

  crudaction(jso, "/services/delete.php", "DELETE", function (result) {
    if (result.success) {
      service_list();
    }
  });
}

function activateService(service_id) {
  const answer = window.confirm("Are you sure?");
  if (!answer) return;
  const service_creator_editor = parseInt($("#service_creator_editor_id").val())
  let jso = { service_id, service_creator_editor };

  crudaction(jso, "/services/activate.php", "PUT", function (result) {
    if (result.success) {
      service_list();
    }
  });
}

function save_service() {
  //immediately show disabled/processing button
  disabledBtn();

  let service_id = parseInt($("#service_edit_id").val());
  let company_id = $("#company_id").val();
  let service_title = $("#service_title").val();
  let service_creator_editor_id = parseInt($("#service_creator_editor_id").val())

  let service_address = $("#service_address").val();
  let next_run = $("#next_run").val();

  let unit = $("#unit").val();
  let frequency = $("#frequency").val();
  const repeated = $("#repeated").val();
  const is_executed = $("#is_executed").val()

  let jso = {
    company_id,
    service_title,
    service_address,
    next_run: timeConversion24Hours(next_run),
    unit,
    frequency,
    service_creator_editor: service_creator_editor_id,
    repeated
  };


  let method = "POST";
  let url = "/services/add.php";

  if (service_id > 0) {
    method = "PUT";
    url = "/services/update.php";
    jso = {
      company_id,
      service_title,
      service_address,
      next_run: timeConversion24Hours(next_run),
      unit,
      frequency,
      service_id,
      service_creator_editor: service_creator_editor_id,
      repeated,
      is_executed
    };
  }

  //make api request
  crudaction(jso, url, method, function (feed) {
    if (feed) {
      //return the normal button
      submitBtn("save_service()");
    }

    if (feed["success"] === false) {
      let message = feed["message"];
      var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2500,
        padding: '0.85rem',
      });

      Toast.fire({
        icon: "error",
        title: message,
        color: "white",
      });

    } else if (feed["success"] === true) {
      let message = feed["message"];

      var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2500,
        padding: '0.85rem',
      });

      Toast.fire({
        icon: "success",
        title: message,
      });
    }
  });
}

/////------End Functionalities

/////------Begin subFunctionalities

function save_subfunctionality() {
  //immediately show disabled/processing button
  disabledBtn();

  let subfun_id = parseInt($("#subfun_edit_id").val());
  let func_id = $("#fun_").val();
  let name = $("#subfun_").val();
  let method = "POST";
  if (subfun_id > 0) {
    method = "PUT";
  }

  jso = {
    func_id: func_id,
    name: name,
    added_by: 1,
  };

  //make api request
  crudaction(
    jso,
    "/edit-subfunctionality/" + subfun_id,
    method,
    function (feed) {
      if (feed) {
        //return the normal button
        submitBtn();
      }

      // console.log(JSON.stringify(feed));

      if (feed["success"] === false) {
        let message = feed["message"];
        $("#feedback").html(
          '<div style="font-size: 16px" class="text-center alert alert-danger alert-dismissible" role="alert">\n' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
            "" +
            message +
            ".\n" +
            "</div>"
        );
        setTimeout(function () {
          $("#feedback").html("");
        }, 4000);
      } else if (feed["success"] === true) {
        let message = feed["message"];
        $("#feedback").html(
          '<div style="font-size: 16px" class="text-center alert alert-success alert-dismissible" role="alert">\n' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
            "" +
            message +
            ".\n" +
            "</div>"
        );
        setTimeout(function () {
          $("#feedback").html("");
        }, 4000);
      }
    }
  );

  crudaction(jso, "/add-subfunctionality", method, function (feed) {
    if (feed) {
      //return the normal button
      submitBtn();
    }

    // console.log(JSON.stringify(feed));

    if (feed["success"] === false) {
      let message = feed["message"];
      $("#feedback").html(
        '<div style="font-size: 16px" class="text-center alert alert-danger alert-dismissible" role="alert">\n' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
          "" +
          message +
          ".\n" +
          "</div>"
      );
      setTimeout(function () {
        $("#feedback").html("");
      }, 4000);
    } else if (feed["success"] === true) {
      let message = feed["message"];
      $("#feedback").html(
        '<div style="font-size: 16px" class="text-center alert alert-success alert-dismissible" role="alert">\n' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
          "" +
          message +
          ".\n" +
          "</div>"
      );
      setTimeout(function () {
        $("#feedback").html("");
      }, 4000);
    }
  });
}

function apiSubfunLoad(offset = 0, rpp = 30) {
  //show loader
  $("#subfun_list").html(
    '<div class="row pt-5 pb-5">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6 d-flex justify-content-center align-items-center">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );
  let status = 1;
  let orStatus = 0;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orStatus=" +
    orStatus +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/subfunctionalities" + query, "GET", function (result) {
    let data = result["data"];
    let data_length = data.length;
    //$("#fun_count").html(data_length);
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let subfunction_id = data[i].uid;
        //let function_id = data[i].func_id;
        let function_name = data[i].name;
        let status = data[i].status;
        count++;

        let statusView = "";
        let actionView = "";

        if (status == 1) {
          statusView =
            '<span class="badge badge-pill badge-success">Active</span>';
          actionView =
            '<span><a href="javascript:void(0)" onclick="deleteSubfun(' +
            subfunction_id +
            ')"><span style="color:white;" class="btn btn-danger fa fa-times"> Delete</span></a></span>';
        } else {
          statusView =
            '<span class="badge badge-pill badge-danger">Deleted</span>';
          actionView =
            '<span><a href="javascript:void(0)" onclick="activateSubfun(' +
            subfunction_id +
            ')"><span style="color:white;" class="btn btn-primary"> Activate</span></a></span>';
        }

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          function_name +
          "</td>\n" +
          "<td>" +
          statusView +
          "</td>\n" +
          "<td>" +
          '<span><a href="?subfun=' +
          subfunction_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="?subfun-add-edit=' +
          subfunction_id +
          '"><span class="btn btn-warning fa fa-pencil"> Update</a></span>  ' +
          actionView +
          "</td>\n" +
          "</tr>";
      }
      $("#subfun_list").html(row);
    } else {
      //////-------No functionalities found
      $("#subfun_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function loadSubfunById() {
  //show loader
  $("#nav-details").html(
    '<div class="row d-flex justify-content-center align-items-center">' +
      '<div class="col-md-6"></div>' +
      '<div class="col-md-6">' +
      '<div class="spinner-border" role="status">' +
      '<span class="sr-only">Loading...</span>' +
      "</div>" +
      "</div>" +
      "</div>"
  );

  let subfun_id = $("#subfun_").val();

  let jso = {};
  let status = 1;
  let orStatus = 0;
  let query = "?status=" + status + "&orStatus=" + orStatus;

  crudaction(
    jso,
    "/subfunctionality/" + subfun_id + query,
    "GET",
    function (result) {
      let data = result["data"];
      let row = "";

      if (data) {
        let subfunction_id = data.uid;
        let function_id = data.func_id;
        let subfunction_name = data.name;
        let added_date = data.added_at;
        let added_by = data.added_by;

        $(".subfun_name").html(subfunction_name);

        row +=
          '<div class="row">\n' +
          '<div class="col-md-7 table-responsive">\n' +
          "<h3>Primary Details</h3>\n" +
          '<table class="table-bordered font-14 table table-hover">\n' +
          "<tr>\n" +
          "<td>ID</td>\n" +
          "<td>" +
          subfunction_id +
          "</td>\n" +
          "</tr>\n" +
          "<tr>\n" +
          "<td>Subfunction</td>\n" +
          "<td>" +
          subfunction_name +
          "</td>\n" +
          "</tr>\n" +
          "<tr>\n" +
          "<tr>\n" +
          "<td>Function</td>\n" +
          "<td>" +
          function_id +
          "</td>\n" +
          "</tr>\n" +
          "<td>Added By</td>\n" +
          "<td>" +
          added_by +
          "</td>\n" +
          "</tr>\n" +
          "<tr>\n" +
          "<td>Added Date</td>\n" +
          "<td>" +
          added_date +
          "</td>\n" +
          "</tr>\n" +
          "</table>\n" +
          "</div>\n" +
          '<div class="col-md-2"></div>' +
          '<div class="col-md-3">\n' +
          '<table class="table">\n' +
          "<tr>\n" +
          '<td><a href="subfunctionalities?subfun-add-edit=' +
          subfunction_id +
          '" class="btn btn-warning btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
          "</tr>";
        "</table>\n" + "</div>\n" + "</div>";
        $("#nav-details").html(row);
      } else {
        //////-------No functionalities found
        $("#nav-details").html(
          "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
        );
      }
    }
  );
}

function deleteSubfun(subfun_id) {
  const answer = window.confirm("Are you sure?");
  if (!answer) return;

  let jso = {};
  let param = "/" + subfun_id;

  crudaction(jso, "/del-subfunctionality" + param, "DELETE", function (result) {
    if (result) {
      apiSubfunLoad();
    }
  });
}

function activateSubfun(subfun_id) {
  const answer = window.confirm("Are you sure?");
  if (!answer) return;

  let jso = { subfun_id: subfun_id };

  crudaction(jso, "/reactivate-subfunctionality", "PUT", function (result) {
    if (result) {
      apiSubfunLoad();
    }
  });
}

function funSelect() {
  let subfuneditid = $("#subfun_edit_id").val();
  funobj = JSON.parse(sessionStorage.getItem("fun"));
  let objCount = subfunobj.length;
  let fun = "";
  for (i = 0; i < objCount; i++) {
    let fun_name = funobj[i].name;
    let fun_id = funobj[i].uid;

    if (subfuneditid == fun_id) {
      var selected = "SELECTED";
    } else {
      var selected = "";
    }
    fun +=
      "<option " +
      selected +
      ' value="' +
      fun_id +
      '">' +
      fun_name +
      "</option>\n";
    $("#sel_funId").html(fun);
  }
}

function localSubfunLoad() {
  let subfunobjs = JSON.parse(sessionStorage.getItem("subfuncs")); //getting subfunction objects from browser sessionStorage
  let subfun = "";

  let data_length = subfunobjs.length;
  if (data_length > 0) {
    for (let i = 0; i < data_length; i++) {
      let subfunction_id = subfunobjs[i].uid;
      let subfunction_name = subfunobjs[i].name;
      let function_id = subfunobjs[i].func_id;
      (subfun +=
        "<li>\n" +
        '       <a href="#" onclick="load_implementations(' +
        function_id),
        subfunction_id +
          ')"><span data-hover="' +
          subfunction_id +
          '">' +
          subfunction_name +
          "</span></a>\n" +
          "</li>";

      $("#subfun" + function_id + "").append(subfun);
    }
  } else {
    //$("#subfun").html("<li>No subfunctions Loaded.</li>");
  }
}

/////------End subFunctionalities

//////------Begin Languages
function apilanguageLoad(offset = 0, rpp = 10) {
  let status = 1;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/languages" + query, "GET", function (result) {
    let data = result["data"];
    let data_length = data.length;
    //$("#fun_count").html(data_length);
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let lang_id = data[i].uid;
        let lang_name = data[i].name;
        //let description = data[i].description;
        let lang_icon = data[i].icon;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          lang_name +
          "</td>\n" +
          '<td><img src="../assets/images/languages/resized/' +
          lang_icon +
          '" height="32" width="32" /></td>\n' +
          '<td><span class="label bg-green">Active</span></td>\n' +
          "<td>" +
          '<span><a href="?lang=' +
          lang_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deleteLang(' +
          lang_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#lang_list").html(row);
    } else {
      //////-------No functionalities found
      $("#lang_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("lang", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadLanguageById() {
  let jso = {};
  let lang_id = $("#lang_").val();

  crudaction(jso, "/languages/" + lang_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let language_id = data.uid;
      let language_name = data.name;
      let description = data.description;
      let added_date = data.added_at;
      let added_by = data.added_by;
      let language_icon = data.icon;

      $(".lang_name").html(language_name);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<img src="../assets/images/languages/resized/' +
        language_icon +
        '" width="100" height="100"/>' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>ID</td>\n" +
        "<td>" +
        language_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Name</td>\n" +
        "<td>" +
        language_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        description +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        added_date +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="languages?language-add-edit=' +
        language_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#langdetails").html(row);
    } else {
      //////-------No functionalities found
      $("#langdetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function deleteLang(lang_id) {
  let jso = {};
  let param = "/" + lang_id;

  crudaction(jso, "/languages" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}

function addEditLanguage() {
  let lang_id = parseInt($("#lang_edit_id").val());
  let jso = {};
  let form = "";

  if (lang_id > 0) {
    crudaction(jso, "/languages/" + lang_id, "GET", function (result) {
      let data = result["data"];
      if (data) {
        //let function_id = data.uid;
        let language_name = data.name;
        let description = data.description;
        let language_icon = data.icon;
        $("#lang_name").html(language_name);

        form +=
          '<h3><span class="text-orange"><i class="fa fa-edit"></i>Edit </span>Language Details</h3>\n' +
          '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
          '<div class="box-body">\n' +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="name" id="name" value="' +
          language_name +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
          '<div class="col-sm-9">\n' +
          '<textarea class="form-control" id="langdesc">' +
          description +
          "</textarea>\n" +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Old Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<img src="../assets/images/languages/resized/' +
          language_icon +
          '" width="100" height="100"/>\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Upload New Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="file" name="file_" id="file_">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="col-sm-3"></div>\n' +
          '<div class="col-sm-9">\n' +
          '<div class="box-footer">\n' +
          '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
          '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveLanguage()">Submit </button>\n' +
          "</div>\n" +
          "</div>\n" +
          "</div>\n" +
          "</form>";
        $("#langAddEditForm").html(form);
      } else {
      }
    });
  } else {
    form +=
      '<h3><span class="text-green"><i class="fa fa-edit"></i>Add</span> Language Details</h3>\n' +
      '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
      '<div class="box-body">\n' +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="name" id="name" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
      '<div class="col-sm-9">\n' +
      '<textarea class="form-control" id="langdesc"></textarea>\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Icon</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="file" name="file_" id="file_">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="col-sm-3"></div>\n' +
      '<div class="col-sm-9">\n' +
      '<div class="box-footer">\n' +
      '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
      '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveFunctionality()">Submit </button>\n' +
      "</div>\n" +
      "</div>\n" +
      "</div>\n" +
      "</form>";
    $("#langAddEditForm").html(form);
  }
}

//////---------------------End Languages

//////------Begin framework
function apiFrameworksLoad(offset = 0, rpp = 10) {
  let status = 1;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/frameworks" + query, "GET", function (result) {
    let data = result["data"];
    let data_length = data.length;
    //$("#fun_count").html(data_length);
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let framework_id = data[i].uid;
        let framework_name = data[i].name;
        let framework_icon = data[i].icon;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          framework_name +
          "</td>\n" +
          '<td><img src="../assets/images/frameworks/' +
          framework_icon +
          '" height="32" width="32" /></td>\n' +
          '<td><span class="label bg-green">Active</span></td>\n' +
          "<td>" +
          '<span><a href="?fram=' +
          framework_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deleteFram(' +
          framework_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#fram_list").html(row);
    } else {
      //////-------No functionalities found
      $("#fram_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("fram", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadFrameworkById() {
  let jso = {};
  let fram_id = $("#fram_edit_id").val();

  crudaction(jso, "/frameworks/" + fram_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let framework_id = data.uid;
      let framework_name = data.name;
      let description = data.description;
      let language_id = data.language_id;
      let framework_icon = data.icon;
      let added_date = data.added_at;
      let added_by = data.added_by;

      $(".fram_name").html(framework_name);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<img src="../assets/images/frameworks' +
        framework_icon +
        '" width="100" height="100"/>' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>Language ID</td>\n" +
        "<td>" +
        language_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Framework ID</td>\n" +
        "<td>" +
        framework_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Name</td>\n" +
        "<td>" +
        framework_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        description +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        added_date +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="frameworks?fram-add-edit=' +
        framework_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#framdetails").html(row);
    } else {
      //////-------No functionalities found
      $("#framdetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function addEditFramewok() {
  let fram_id = parseInt($("#fram_edit_id").val());
  let jso = {};
  let form = "";

  if (fram_id > 0) {
    crudaction(jso, "/frameworks/" + fram_id, "GET", function (result) {
      let data = result["data"];
      if (data) {
        let language_id = data.language_id;
        let framework_id = data.uid;
        let framework_name = data.name;
        let description = data.description;
        let framework_icon = data.icon;
        $("#fram_name").html(framework_name);

        form +=
          '<h3><span class="text-orange"><i class="fa fa-edit"></i>Edit </span>Framework Details</h3>\n' +
          '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
          '<div class="box-body">\n' +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Language ID</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="lamg_id_" id="lang_id_" value="' +
          language_id +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Framework ID</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="fram_id_" id="fram_id_" value="' +
          framework_id +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="name" id="name" value="' +
          framework_name +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
          '<div class="col-sm-9">\n' +
          '<textarea class="form-control" id="framdesc">' +
          description +
          "</textarea>\n" +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Old Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<img src="../assets/images/frameworks' +
          framework_icon +
          '" width="100" height="100"/>\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Upload New Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="file" name="file_" id="file_">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="col-sm-3"></div>\n' +
          '<div class="col-sm-9">\n' +
          '<div class="box-footer">\n' +
          '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
          '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveFramework()">Submit </button>\n' +
          "</div>\n" +
          "</div>\n" +
          "</div>\n" +
          "</form>";
        $("#framAddEditForm").html(form);
      } else {
      }
    });
  } else {
    form +=
      '<h3><span class="text-green"><i class="fa fa-edit"></i>Add</span> Framework Details</h3>\n' +
      '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
      '<div class="box-body">\n' +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Language ID</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="lamg_id_" id="lang_id_" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Framework ID</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="fram_id_" id="fram_id_" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="name" id="name" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
      '<div class="col-sm-9">\n' +
      '<textarea class="form-control" id="framdesc"></textarea>\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Icon</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="file" name="file_" id="file_">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="col-sm-3"></div>\n' +
      '<div class="col-sm-9">\n' +
      '<div class="box-footer">\n' +
      '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
      '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveFramwork()">Submit </button>\n' +
      "</div>\n" +
      "</div>\n" +
      "</div>\n" +
      "</form>";
    $("#framAddEditForm").html(form);
  }
}

function deleteFram(fram_id) {
  let jso = {};
  let param = "/" + fram_id;

  crudaction(jso, "/frameworks" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}

//////---------------------End frameworks

//////------Begin implementation
function apiImplementationsLoad(offset = 0, rpp = 10) {
  let status = 1;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/implementations" + query, "GET", function (result) {
    let data = result["data"];
    let data_length = data.length;
    //$("#fun_count").html(data_length);
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let impl_id = data[i].uid;
        let upvoters = data[i].upvoters;
        let downvoters = data[i].downvoters;
        let impl_title = data[i].title;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          impl_title +
          "</td>\n" +
          "<td>" +
          upvoters +
          "</td>\n" +
          "<td>" +
          downvoters +
          "</td>\n" +
          "<td>" +
          '<span><a href="?impl=' +
          impl_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deleteImpl(' +
          impl_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#impl_list").html(row);
    } else {
      //////-------No functionalities found
      $("#impl_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("impl", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadImplementatonById() {
  let jso = {};
  let impl_id = $("#impl_edit_id").val();

  crudaction(jso, "/implementations/" + impl_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let impl_id = data.uid;
      let impl_title = data.title;
      let description = data.description;
      let fun_id = data.func_id;
      let subfun_id = data.subfunc_id;
      let added_by = data.added_by;
      let added_date = data.added_date;
      let upvoters = data.upvoters;
      let downvoters = data.downvoters;

      $(".impl_name").html(impl_title);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<span class="info-box-icon"><i class="fa fa-info"></i></span>\n' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>Implementation ID</td>\n" +
        "<td>" +
        impl_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Title</td>\n" +
        "<td>" +
        impl_title +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        description +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Function ID</td>\n" +
        "<td>" +
        fun_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Subfunction ID</td>\n" +
        "<td>" +
        subfun_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        added_date +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Upvoters</td>\n" +
        "<td>" +
        upvoters +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Downvoters</td>\n" +
        "<td>" +
        downvoters +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="implementations?impl-add-edit=' +
        impl_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#impldetails").html(row);
    } else {
      //////-------No functionalities found
      $("#impldetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function addEditImplementation() {
  let impl_id = parseInt($("#impl_edit_id").val());
  let jso = {};
  let form = "";

  if (impl_id > 0) {
    crudaction(jso, "/implementations/" + impl_id, "GET", function (result) {
      let data = result["data"];
      if (data) {
        let impl_title = data.title;
        let description = data.description;
        let fun_id = data.func_id;
        let subfun_id = data.subfunc_id;

        $("#impl_name").html(impl_title);

        form +=
          '<h3><span class="text-orange"><i class="fa fa-edit"></i>Edit </span>Implementation Details</h3>\n' +
          '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
          '<div class="box-body">\n' +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Implementation Title</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="impl_id_" id="impl_id_" value="' +
          impl_title +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
          '<div class="col-sm-9">\n' +
          '<textarea class="form-control" id="impldesc">' +
          description +
          "</textarea>\n" +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Function ID</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="fun_id_" id="fun_id_" value="' +
          fun_id +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Subfunction ID</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="subfun_id_" id="subfun_id_" value="' +
          subfun_id +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="col-sm-3"></div>\n' +
          '<div class="col-sm-9">\n' +
          '<div class="box-footer">\n' +
          '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
          '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveImplementation()">Submit </button>\n' +
          "</div>\n" +
          "</div>\n" +
          "</div>\n" +
          "</form>";
        $("#implAddEditForm").html(form);
      } else {
      }
    });
  } else {
    form +=
      '<h3><span class="text-green"><i class="fa fa-edit"></i>Add</span> Framework Details</h3>\n' +
      '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
      '<div class="box-body">\n' +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Implementation Title</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="impl_id_" id="impl_id_" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
      '<div class="col-sm-9">\n' +
      '<textarea class="form-control" id="impldesc"></textarea>\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Function ID</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="fun_id_" id="fun_id_" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Subfunction ID</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="subfun_id_" id="subfun_id_" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="col-sm-3"></div>\n' +
      '<div class="col-sm-9">\n' +
      '<div class="box-footer">\n' +
      '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
      '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveImplementation()">Submit </button>\n' +
      "</div>\n" +
      "</div>\n" +
      "</div>\n" +
      "</form>";
    $("#implAddEditForm").html(form);
  }
}

function deleteImpl(impl_id) {
  let jso = {};
  let param = "/" + impl_id;

  crudaction(jso, "/implementations" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}
//////---------------------End implementation

//////------Begin codeSnippet
function load_codeSnippet() {
  let sel_env = parseInt($("#sel_env").val());
  let sel_language = parseInt($("#sel_language").val());
  let sel_framework = parseInt($("#sel_framework").val());
  let sel_implementation = parseInt($("#sel_implementation").val());
  let sel_dbms = parseInt($("#sel_dbms").val());

  if (!sel_env) {
    sel_env = 0;
  }

  if (!sel_language) {
    sel_language = 0;
  }

  if (!sel_framework) {
    sel_framework = 0;
  }

  if (!sel_implementation) {
    sel_implementation = 0;
  }

  if (!sel_dbms) {
    sel_dbms = 0;
  }
  let codeEditor = ace.edit("editor");
  //var dbCode = $('#editorCode_').val();
  //$('#editorCode2_').html(dbCode);
  //console.log(dbCode);
  //const dbCode = 'console.log("Hello World")';

  let editorLib = {
    init() {
      //Configure Ace
      codeEditor.setTheme("ace/theme/monokai");

      //Set Languages
      codeEditor.session.setMode("ace/mode/javascript");
      codeEditor.session.setMode("ace/mode/java");
      //codeEditor.session.setMode("ace/mode.html");
      //codeEditor.session.setMode("ace/mode/php");
      //Set Options
      codeEditor.setOptions({
        //fontFamily: 'Inconsolata'
        fontSize: "12pt",
        //enableBasicAutocompletion: true,
        //enableLiveAutocompletion: true
      });

      //Set default code

      let status = 1;
      let orderby = "name";
      let dir = "ASC";

      let jso = {};

      let query =
        "?status=" +
        status +
        "&orderby=" +
        orderby +
        "&dir=" +
        dir +
        "&language_id=" +
        sel_language +
        "&framework_id=" +
        sel_framework +
        "&implementation_id=" +
        sel_implementation +
        "&dbms_id=" +
        sel_dbms +
        "&environment_id=" +
        sel_env;

      console.log(query);

      crudaction(jso, "/codeSnippet" + query, "GET", function (result) {
        ////////--------Result should look something like this
        //////   {\"result_\":$result_,\"details_\":$details_,\"total_\":$totalcount}
        //////---------$details is a a JSON representation of multiple MYSQL Rows

        //let json_ = JSON.parse(result).details_;
        let data = result["data"];
        let total_ = data.length;
        //console.log(total_);
        let codeSnippet = "";

        if (total_ > 0) {
          for (var i = 0; i < data.length; i++) {
            let rowCode = data[i].row_code;
            codeSnippet += rowCode;
          }
          //$('#dbCode_').val(codeSnippet);
          codeEditor.setValue(codeSnippet);
        } else {
          //////-------No Languages found
          //$('#dbCode_').val("<li>No Code Loaded.</li>");
          codeEditor.setValue("No Code Loaded.");
        }
      });
    },
  };

  editorLib.init();
}

//////---------------------End codeSnippet

//////------Begin dbms
function apiDbmsLoad(offset = 0, rpp = 10) {
  let status = 1;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/dbms" + query, "GET", function (result) {
    let data = result["data"];
    let data_length = data.length;
    //$("#fun_count").html(data_length);
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let dbms_id = data[i].uid;
        let dbms_name = data[i].name;
        let dbms_icon = data[i].icon;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          dbms_name +
          "</td>\n" +
          '<td><img src="../assets/images/dbms/resized/' +
          dbms_icon +
          '" height="32" width="32" /></td>\n' +
          '<td><span class="label bg-green">Active</span></td>\n' +
          "<td>" +
          '<span><a href="?dbms=' +
          dbms_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deleteDbms(' +
          dbms_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#dbms_list").html(row);
    } else {
      //////-------No functionalities found
      $("#dbms_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("dbms", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadDbmsById() {
  let jso = {};
  let dbms_id = $("#dbms_").val();

  crudaction(jso, "/dbms/" + dbms_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let dbms_id = data.uid;
      let dbms_name = data.name;
      let description = data.description;
      let added_date = data.added_at;
      let added_by = data.added_by;
      let dbms_icon = data.icon;

      $(".dbms_name").html(dbms_name);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<img src="../assets/images/dbms/resized/' +
        dbms_icon +
        '" width="100" height="100"/>' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>ID</td>\n" +
        "<td>" +
        dbms_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Name</td>\n" +
        "<td>" +
        dbms_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        description +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        added_date +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="dbms?dbms-add-edit=' +
        dbms_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#dbmsdetails").html(row);
    } else {
      //////-------No functionalities found
      $("#dbmsdetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function addEditDbms() {
  let dbms_id = parseInt($("#dbms_edit_id").val());
  let jso = {};
  let form = "";

  if (dbms_id > 0) {
    crudaction(jso, "/dbms/" + dbms_id, "GET", function (result) {
      let data = result["data"];
      if (data) {
        //let function_id = data.uid;
        let dbms_name = data.name;
        let description = data.description;
        let dbms_icon = data.icon;
        $("#dbms_name").html(dbms_name);

        form +=
          '<h3><span class="text-orange"><i class="fa fa-edit"></i>Edit </span> Dbms Details</h3>\n' +
          '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
          '<div class="box-body">\n' +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="name" id="name" value="' +
          dbms_name +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
          '<div class="col-sm-9">\n' +
          '<textarea class="form-control" id="dbmsdesc">' +
          description +
          "</textarea>\n" +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Old Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<img src="../assets/images/dbms/resized/' +
          dbms_icon +
          '" width="100" height="100"/>\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Upload New Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="file" name="file_" id="file_">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="col-sm-3"></div>\n' +
          '<div class="col-sm-9">\n' +
          '<div class="box-footer">\n' +
          '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
          '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveDbms()">Submit </button>\n' +
          "</div>\n" +
          "</div>\n" +
          "</div>\n" +
          "</form>";
        $("#dbmsAddEditForm").html(form);
      } else {
      }
    });
  } else {
    form +=
      '<h3><span class="text-green"><i class="fa fa-edit"></i>Add</span> Dbms Details</h3>\n' +
      '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
      '<div class="box-body">\n' +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="name" id="name" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
      '<div class="col-sm-9">\n' +
      '<textarea class="form-control" id="dbmsdesc"></textarea>\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Icon</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="file" name="file_" id="file_">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="col-sm-3"></div>\n' +
      '<div class="col-sm-9">\n' +
      '<div class="box-footer">\n' +
      '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
      '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="saveFunctionality()">Submit </button>\n' +
      "</div>\n" +
      "</div>\n" +
      "</div>\n" +
      "</form>";
    $("#dbmsAddEditForm").html(form);
  }
}

function deleteDbms(dbms_id) {
  let jso = {};
  let param = "/" + dbms_id;

  crudaction(jso, "/dbms" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}
//////---------------------End dbms

//////-------------------------------Begin Platforms/environments

function apiPlatformsLoad(offset = 0, rpp = 10) {
  let status = 1;
  let orderby = "name";
  let dir = "ASC";

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/environments" + query, "GET", function (result) {
    let data = result["data"];
    //$("#fun_count").html(data_length);
    let data_length = data.length;
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let plt_id = data[i].uid;
        let plt_name = data[i].name;
        let plt_icon = data[i].icon;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          plt_name +
          "</td>\n" +
          '<td><img src="../assets/images/environments/' +
          plt_icon +
          '" height="32" width="32" /></td>\n' +
          '<td><span class="label bg-green">Active</span></td>\n' +
          "<td>" +
          '<span><a href="?plt=' +
          plt_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deletePlatform(' +
          plt_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#plt_list").html(row);
    } else {
      //////-------No functionalities found
      $("#plt_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("plt", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadPlatformById() {
  let jso = {};
  let plt_id = $("#plt_").val();

  crudaction(jso, "/environments/" + plt_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let plt_id = data.uid;
      let plt_name = data.name;
      let description = data.description;
      let added_date = data.added_at;
      let added_by = data.added_by;
      let plt_icon = data.icon;

      $(".plt_name").html(plt_name);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<img src="../assets/images/environments/' +
        plt_icon +
        '" width="100" height="100"/>' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>ID</td>\n" +
        "<td>" +
        plt_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Title</td>\n" +
        "<td>" +
        plt_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        description +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        added_by +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        added_date +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="platforms?plt-add-edit=' +
        plt_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#pltdetails").html(row);
    } else {
      //////-------No functionalities found
      $("#pltdetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function addEditPlatform() {
  let plt_id = parseInt($("#plt_edit_id").val());
  let jso = {};
  let form = "";

  if (plt_id > 0) {
    crudaction(jso, "/environments/" + plt_id, "GET", function (result) {
      let data = result["data"];
      if (data) {
        //let function_id = data.uid;
        let plt_name = data.name;
        let description = data.description;
        let plt_icon = data.icon;
        $("#plt_name").html(plt_name);

        form +=
          '<h3><span class="text-orange"><i class="fa fa-edit"></i>Edit </span> Platform Details</h3>\n' +
          '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
          '<div class="box-body">\n' +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="text" name="name" id="name" value="' +
          plt_name +
          '">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
          '<div class="col-sm-9">\n' +
          '<textarea class="form-control" id="pltdesc">' +
          description +
          "</textarea>\n" +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Old Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<img src="../assets/images/environments/' +
          plt_icon +
          '" width="100" height="100"/>\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="form-group">\n' +
          '<label for="name" class="col-sm-3 control-label">Upload New Icon</label>\n' +
          '<div class="col-sm-9">\n' +
          '<input class="form-control" type="file" name="file_" id="file_">\n' +
          "</div>\n" +
          "</div>\n" +
          '<div class="col-sm-3"></div>\n' +
          '<div class="col-sm-9">\n' +
          '<div class="box-footer">\n' +
          '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
          '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="savePlatform()">Submit </button>\n' +
          "</div>\n" +
          "</div>\n" +
          "</div>\n" +
          "</form>";
        $("#pltAddEditForm").html(form);
      } else {
      }
    });
  } else {
    form +=
      '<h3><span class="text-green"><i class="fa fa-edit"></i>Add</span> Platform Details</h3>\n' +
      '<form class="form-horizontal" onsubmit="return false;" method="POST" enctype="multipart/form-data">\n' +
      '<div class="box-body">\n' +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Name</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="text" name="name" id="name" value="">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Description</label>\n' +
      '<div class="col-sm-9">\n' +
      '<textarea class="form-control" id="pltdesc"></textarea>\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="form-group">\n' +
      '<label for="name" class="col-sm-3 control-label">Icon</label>\n' +
      '<div class="col-sm-9">\n' +
      '<input class="form-control" type="file" name="file_" id="file_">\n' +
      "</div>\n" +
      "</div>\n" +
      '<div class="col-sm-3"></div>\n' +
      '<div class="col-sm-9">\n' +
      '<div class="box-footer">\n' +
      '<button type="submit" class="btn btn-lg btn-default">Cancel</button>\n' +
      '<button type="submit" class="btn btn-success btn-lg pull-right" onclick="savePlatform()">Submit </button>\n' +
      "</div>\n" +
      "</div>\n" +
      "</div>\n" +
      "</form>";
    $("#pltAddEditForm").html(form);
  }
}

function deletePlatform(plt_id) {
  let jso = {};
  let param = "/" + plt_id;

  crudaction(jso, "/environments" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}

//////-------------------------------End Platforms/environment

//////------------Begin users
function addCurrentuserNavbar() {
  let user = JSON.parse(sessionStorage.getItem("currentAdmin"));
}

function apiUsersLoad() {
  let status = parseInt($("#_status_").val());
  let orderby = $("#_orderby_").val();
  let dir = $("#_dir_").val();
  let offset = parseInt($("#_offset_").val());
  let rpp = parseInt($("#_rpp_").val());

  let jso = {};
  //let fun = "";

  let query =
    "?status=" +
    status +
    "&orderby=" +
    orderby +
    "&dir=" +
    dir +
    "&offset=" +
    offset +
    "&rpp=" +
    rpp;

  crudaction(jso, "/users" + query, "GET", function (result) {
    let data = result["data"];
    //$("#fun_count").html(data_length);
    let data_length = data.length;
    let row = "";
    let count = 0;

    if (data_length > 0) {
      for (let i = 0; i < data_length; i++) {
        let user_id = data[i].uid;
        let username = data[i].username;
        let email = data[i].email;
        let country = data[i].country;
        count++;

        row +=
          "<tr>\n" +
          "<td>" +
          count +
          "</td>\n" +
          "<td>" +
          username +
          "</td>\n" +
          "<td>" +
          email +
          "</td>\n" +
          "<td>" +
          country +
          "</td>\n" +
          "<td>" +
          '<span><a href="?user=' +
          user_id +
          '"><span class="btn btn-default fa fa-eye"> View</a></span>  ' +
          '<span><a href="#" onclick="deleteUser(' +
          user_id +
          ')"><span class="btn btn-danger fa fa-times"> Delete</a></span>' +
          "</td>\n" +
          "</tr>";
      }
      $("#users_list").html(row);
      //setTimeout(function () {
      //pager_refactor();
      //}, 500);
    } else {
      //////-------No functionalities found
      $("#users_list").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }

    //creating a local storage
    if (typeof Storage !== "undefined") {
      sessionStorage.setItem("currentAdmin", JSON.stringify(data));
      console.log(sessionStorage);
    } else {
      console.log("Browser not supported");
    }
  });
}

function loadUserById() {
  let jso = {};
  let user_id = $("#user_").val();

  crudaction(jso, "/users/" + user_id, "GET", function (result) {
    let data = result["data"];
    let row = "";

    if (data) {
      let user_id = data.uid;
      let user_name = data.username;
      let email = data.email;
      let join_date = data.join_date;
      let country = data.country;
      let gender = data.gender;

      $(".user_name").html(user_name);

      row +=
        '<div class="row">\n' +
        '<div class="col-md-2">\n' +
        '<i class="fa fa-user"></i>' +
        "</div>\n" +
        '<div class="col-md-7">\n' +
        "<h3>Primary Details</h3>\n" +
        '<table class="table-bordered font-14 table table-hover">\n' +
        "<tr>\n" +
        "<td>ID</td>\n" +
        "<td>" +
        user_id +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Title</td>\n" +
        "<td>" +
        user_name +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Description</td>\n" +
        "<td>" +
        email +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        gender +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added By</td>\n" +
        "<td>" +
        join_date +
        "</td>\n" +
        "</tr>\n" +
        "<tr>\n" +
        "<td>Added Date</td>\n" +
        "<td>" +
        country +
        "</td>\n" +
        "</tr>\n" +
        "</table>\n" +
        "</div>\n" +
        '<div class="col-md-3">\n' +
        '<table class="table">\n' +
        "<tr>\n" +
        '<td><a href="users?useradd-edit=' +
        user_id +
        '" class="btn btn-primary btn-block  btn-md grid-width-10"><i class="fa fa-pencil"> Update</i></a></td>' +
        "</tr>";
      "</table>\n" + "</div>\n" + "</div>";
      $("#userdetails").html(row);
    } else {
      //////-------No functionalities found
      $("#userdetails").html(
        "<tr><td colspan='5'><i>No Records Found</i></td></tr>"
      );
    }
  });
}

function deleteUser(uid) {
  let jso = {};
  let param = "/" + uid;

  crudaction(jso, "/users" + param, "DELETE", function (result) {
    if (result) {
      reload();
    }
  });
}

function registerAdmin() {
  let inp_username = $("#inp_username").val();
  let inp_email = $("#inp_email").val();
  let inp_country = $("#inp_country").val();
  let inp_password = $("#inp_password").val();
  let inp_cpassword = $("#inp_cpassword").val();

  let jso = {
    username: "" + inp_username + "",
    email: "" + inp_email + "",
    country: "" + inp_country + "",
    password: "" + inp_password + "",
    cpassword: "" + inp_cpassword + "",
  };
  console.log(jso);

  crudaction(jso, "/users", "POST", function (feed) {
    let success = parseInt(feed.success);
    console.log(JSON.stringify(feed));
    //feedback("DEFAULT", "TOAST", "#regfeedback", feed.message, "4");
  });
}

function logoutAdmin() {
  const adminlogout = sessionStorage.removeItem("currentAdmin");
  if (adminlogout) {
    window.location.href = "login";
  }
}
/////////-------------End users
