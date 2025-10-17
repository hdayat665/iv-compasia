# base image
FROM node:20-alpine

# working dir
WORKDIR /app

# copy package files
COPY package*.json ./

# install dependencies
RUN npm install

# copy all source files
COPY . .

# expose port
EXPOSE 5173

# command to run dev server
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
