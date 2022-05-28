# MyDb

## Development commands
```
docker build -t jmdirksen/mydb:latest .

docker push jmdirksen/mydb:latest

docker compose up -d

docker compose down
```

## Deploy
Use the [docker-compose.yml](docker-compose.yml) for deploying the app.
The database container should not be accessible from the outside but the password "secret" should be changed to something more secure.

### SSL/HTTPS

For a secure connection a container like the [jc21/nginx-proxy-manager](https://hub.docker.com/r/jc21/nginx-proxy-manager) could be used. For that the ```ports: - 80:80 ``` section can be removed and the Nginx Proxy Manager container can be joined to the 'frontend' network.
