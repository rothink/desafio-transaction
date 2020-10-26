FROM node:12.2.0-alpine

COPY ./front /app

RUN ls -la

# set working directory
WORKDIR /app

# install and cache app dependencies
#COPY ./front/package.json /app/package.json

RUN npm install

RUN npm install -g @vue/cli

RUN ls -la

EXPOSE 8080

# start app
CMD ["npm", "run", "serve"]
