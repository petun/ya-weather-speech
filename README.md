# Yandex Weather voice generator #
Get current weather for town and save it as mp3 using yandex speechkit. Based on symfony components.

Installation
===
* git clone https://github.com/petun/ya-weather-speech.git
* cd ya-weather-speech
* composer update
* copy config/main-sample.yml to config/main.yml
* fill configuration file config/main.yml
* run from console - **php run.php speech:weather**
* Get results from cache/ directory.

Debug
===
For debugging just call
```bash
php run.php speech:weather -vvv
```

