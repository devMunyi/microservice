# Use an official PHP image as the base image
FROM php:latest

# Set working directory
WORKDIR /var/www/html

# Copy the PHP application code into the container
COPY . /var/www/html

# Install PHP dependencies if any (e.g., composer)
RUN apt-get update && apt-get install -y zip

# Expose the port your PHP application is running on (e.g., port 80 for HTTP)
EXPOSE 80

# Command to run your PHP application (e.g., if using PHP's built-in server)
CMD ["php", "-S", "0.0.0.0:80"]
