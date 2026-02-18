# PHP Webhook Handler

This is a simple PHP application to handle webhook requests authorized using preset Bearer Tokens mapped to allowed actions. It receives inputs via a JSON payload.

## Setup

1. Configure the `$tokenActions` array in `index.php` with your Bearer tokens and their respective allowed actions.

## Running the App

To start the development server, run:

```bash
php -S localhost:8000 index.php
```

The webhook endpoint will be available at `http://localhost:8000/`.

## Usage

Send a POST request to the endpoint with:

- **Authorization Header**: `Bearer <your-token>`
- **Content-Type**: `application/json`
- **Body**: JSON payload including an `action` field

Example using curl:

```bash
curl -X POST http://localhost:8000/ \
  -H "Authorization: Bearer your-preset-bearer-token" \
  -H "Content-Type: application/json" \
  -d '{"action": "log_data", "key": "value"}'
```

## Processing

The app will:

- Validate the Bearer Token and check if the specified action is allowed for that token.
- Parse the JSON payload.
- Log the action and payload to `webhook_log.txt`.
- Respond with a success message including the action.

Errors:
- 401 Unauthorized: Invalid or missing Bearer Token.
- 400 Bad Request: Invalid JSON payload.
- 403 Forbidden: Action not allowed for the token.