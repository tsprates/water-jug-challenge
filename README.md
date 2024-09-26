# Water Jug Challenge

This project is a `Water Jug Challenge`, consisting of a **PHP-based API** and a **React frontend**, all containerized using Docker. The API provides the logic to solve the water jug problem, while the frontend allows users to input the jug capacities and target volume.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Project Structure](#project-structure)
- [Setup Instructions](#setup-instructions)
- [Running Tests](#running-tests)

## Prerequisites

Before you begin, make sure you have the following software installed on your machine:

- [Docker](https://www.docker.com/products/docker-desktop)

## Project Structure

The project consists of the following key components:

- `api/`: The Laravel PHP API that processes the water jug problem logic.
- `ui/`: The React-based frontend that interacts with the API and displays results.

## Setup Instructions

Follow these steps to get the application up and running:

1. **Start the Docker Containers**:
   Use Docker Compose to start the services. This will start both the API and the UI containers.

```bash
docker-compose up --build
```

This command will:

- Build and start the API (Laravel app) on port `8000`.
- Build and start the UI (React app) on port `80`.

## Running tests:

1 **API (PHP/Laravel Tests)**:
Make sure the API container is running. Open a terminal in the api/ directory and run the following command to execute PHPUnit tests:

```bash
docker exec -it api ./vendor/bin/phpunit
```

**Note**: The first time you run the API, you may need to install PHP dependencies. You can do this by running:

```bash
docker exec -it api php composer install
```

2 **UI (React Tests with Vitest)**:
Make sure the UI container is running. Open a terminal and run:

```bash
docker exec -it ui npm run test
```

**Note**: This will run the React unit tests using Vitest.

## Stopping the Application:

To stop and remove the Docker containers, run:

```bash
docker-compose down
```
