#!/bin/sh
set -e

RESOLVER=$(awk '/^nameserver/ {print $2; exit}' /etc/resolv.conf)
echo "▶ Nginx entrypoint — using resolver: ${RESOLVER}"

sed "s/resolver [^;]*/resolver ${RESOLVER}/" /etc/nginx/conf.d/default.conf > /tmp/nginx-default.conf
cat /tmp/nginx-default.conf > /etc/nginx/conf.d/default.conf

echo "→ Starting nginx..."
exec nginx -g "daemon off;"
