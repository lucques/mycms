# mycms

Simple CMS with focus on a puristic and (slightly overly) extensible architecture (discontinued after 2011, written in PHP 5)

## How to use

Since this is a legacy project, I recommend running it via Docker. The following configuration is used:

- Apache 2
- PHP 5.6
- MySQL 5.7

After installing `docker` and `docker-compose`, simply run

```
cd docker
docker-compose up
```

This both fetches all Docker images and orchestrates them in a LAMP-style manner.

Then go to `http://localhost/install.php` in your web browser to initialize the database. Afterwards, `mycms` runs on `http://localhost/`.

## License

MIT