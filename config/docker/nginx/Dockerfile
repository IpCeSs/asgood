ARG CI_COMMIT_SHA
FROM coworkees/app:$CI_COMMIT_SHA as app

FROM nginx:1.13.6-alpine

ADD config/swarm/dev/nginx /etc/nginx

COPY --from=app /scripts/web /scripts/web
