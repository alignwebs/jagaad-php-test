# Jagaad - Backend PHP tech homework - Step 1 | Development

Gets the list of the cities from Musement's API for each city gets the forecast for the next 2 days using http://api.weatherapi.com and print to STDOUT "Processed city [city name] | [weather today] - [wheather tomorrow]"

## Requirements

- Docker

## Steps

- Set WEATHER_API_KEY env in Dockerfile
- `$ docker build -t alignwebs-jagaad-php-test .`
- `$ docker run -it --rm alignwebs-jagaad-php-test`
