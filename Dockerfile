FROM webdevops/php-nginx:7.4

# ----------------------------------------------
# ---------[Adição de variáveis no ENV]---------
# ----------------------------------------------

ENV WEB_DOCUMENT_ROOT /app/public
ENV WEB_PHP_TIMEOUT 7200
ENV FPM_PROCESS_IDLE_TIMEOUT 7200
ENV FPM_REQUEST_TERMINATE_TIMEOUT 7200

# ----------------------------------------------
# ----------[Espelhamento no conteiner]---------
# ----------------------------------------------

COPY . /app

# ----------------------------------------------
# ----------[Configuração do ambiente]----------
# ----------------------------------------------

RUN cd /app && composer install
RUN chmod +x /app/bin/console
RUN mkdir -p /app/config/jwt

ONBUILD COPY public.pem /app/config/jwt/public.pem
ONBUILD COPY private.pem /app/config/jwt/private.pem

# ----------------------------------------------
# ------[Exposição das portas do container]-----
# ----------------------------------------------

EXPOSE 80 443 9000

WORKDIR /app