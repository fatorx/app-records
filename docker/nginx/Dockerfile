FROM nginx:alpine-3.20.3

RUN apk update
RUN apk add --upgrade apk-tools
RUN apk add vim

RUN apk add --no-cache tzdata
ENV TZ=Africa/Bissau
