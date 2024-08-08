###### Install dependencies only when needed ######
FROM node:20.14.0-alpine AS builder

# Make /app as working directory
WORKDIR /app

# Copy package.json file
COPY portal/package.json ./

# Install dependencies
RUN npm install

# Copy the source code to the /app directory
COPY portal/ ./

# Build the application
RUN npm run build

######  Use NgInx alpine image  ###### 
FROM nginx:stable-alpine

# Remove default nginx website
RUN rm -rf /usr/share/nginx/html/*

# Copy nginx config file
COPY sys/portal/default.conf /etc/nginx/conf.d/default.conf

# Copy dist folder fro build stage to nginx public folder
COPY --from=builder /app/dist/portal /usr/share/nginx/html

# Start Nginx service
CMD ["nginx", "-g", "daemon off;"]