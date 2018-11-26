all: build run

build:
	docker build -t app .

run:
	docker run -p 127.0.0.1:80:80 app