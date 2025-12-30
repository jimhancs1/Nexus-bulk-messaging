# Nexus Bulk Messaging

Nexus Bulk Messaging is a utility for sending high-volume, templated messages through a Nexus-compatible messaging API. It helps you load recipients from a CSV (or other data sources), apply template variables, and dispatch messages at configurable concurrency and retry policies. This repository provides the code, configuration examples, and operational guidance for running bulk campaigns safely and reliably.

> NOTE: This README is intentionally implementation-agnostic. Replace the example commands and script names with the actual entrypoint(s) in this repository (for example `node`, `python`, or a compiled binary).

## Table of Contents
- [Features](#features)
- [Quick Start](#quick-start)
- [Requirements](#requirements)
- [Configuration](#configuration)
- [Input file formats](#input-file-formats)
- [Usage](#usage)
- [Docker](#docker)
- [Best practices](#best-practices)
- [Testing](#testing)
- [Logging & troubleshooting](#logging--troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features
- Read recipients and per-recipient variables from CSV (or JSON).
- Apply message templates with variable substitution.
- Rate-limited and concurrent message dispatch.
- Retry policy for transient API failures.
- Dry-run mode to validate templates and payloads without sending.
- Structured logs and summary reports.

## Quick Start

1. Clone the repository
```bash
git clone https://github.com/jimhancs1/Nexus-bulk-messaging.git
cd Nexus-bulk-messaging
```

2. Install dependencies (example for Node.js)
```bash
npm install
```
Or (example for Python)
```bash
pip install -r requirements.txt
```

3. Create a `.env` file (see [Configuration](#configuration)) and prepare your `recipients.csv` and `template.txt`.

4. Run (replace with actual entrypoint for this repo):
```bash
# Example generic invocation
node ./src/send.js --input recipients.csv --template templates/welcome.txt --dry-run
```

## Requirements
- Access to the Nexus messaging API (API key/credentials).
- Node.js >= 14 / Python 3.8+ (or the language/runtime the project uses).
- Network access to the messaging endpoint.
- Sufficient system resources for desired concurrency.

## Configuration

Configuration primarily comes from environment variables and CLI flags. The exact names below are examples — adapt to the repository's implementation.

Environment variables (.env example)
```
NEXUS_API_URL=https://api.nexus.example.com/v1/messages
NEXUS_API_KEY=your_api_key_here
INPUT_FILE=recipients.csv
TEMPLATE_FILE=templates/welcome.txt
CONCURRENCY=10
RATE_LIMIT=100         # messages per minute (optional)
RETRY_COUNT=3
LOG_LEVEL=info
DRY_RUN=true           # set to false to actually send
```

Common CLI flags
- `--input` or `-i` : path to recipients CSV/JSON
- `--template` or `-t`: path to message template
- `--concurrency` or `-c`: number of concurrent workers
- `--dry-run`: validate only, don't send
- `--report` : path to write a summary report (JSON or CSV)

## Input file formats

CSV (recommended)
- Headers: at minimum include an address column (e.g., `phone`, `email`) and any template variables.
- Example `recipients.csv`:
```
phone,first_name,plan,timezone
+15551234567,Alex,Pro,PST
+15557654321,Jesse,Basic,EST
```

JSON (alternate)
- Example `recipients.json`:
```json
[
  {"phone":"+15551234567","first_name":"Alex","plan":"Pro","timezone":"PST"},
  {"phone":"+15557654321","first_name":"Jesse","plan":"Basic","timezone":"EST"}
]
```

Template file (must match templating syntax used in code)
- Example `templates/welcome.txt` using moustache-like variables:
```
Hi {{first_name}} — welcome to {{plan}}! Reply STOP to opt out.
```

## Usage examples

Dry-run (validate templates & payloads without sending)
```bash
node ./src/send.js --input recipients.csv --template templates/welcome.txt --dry-run
```

Send with concurrency and retries
```bash
node ./src/send.js --input recipients.csv --template templates/welcome.txt --concurrency 20 --retry 5
```

Custom API endpoint and API key (env)
```bash
export NEXUS_API_URL="https://api.nexus.example.com/v1/messages"
export NEXUS_API_KEY="xxxx"
node ./src/send.js -i recipients.csv -t templates/welcome.txt
```

Generate a summary report after run
```bash
node ./src/send.js -i recipients.csv -t templates/welcome.txt --report report.json
```

Interpreting the report
- total: total records processed
- success: messages accepted by Nexus
- failed: messages that failed after retries (includes reason)
- skipped: invalid records (bad phone/email, malformed variables)

## Docker

Example Dockerfile usage (adapt to repo):
```Dockerfile
FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm ci --production
COPY . .
CMD ["node", "src/send.js"]
```

Build and run:
```bash
docker build -t nexus-bulk .
docker run --env-file .env -v $(pwd)/data:/data nexus-bulk --input /data/recipients.csv --template /data/templates/welcome.txt
```

## Best practices
- Run with `--dry-run` first to ensure templates and CSV mapping are correct.
- Use conservative concurrency/rate limits during initial runs.
- Use segmented campaigns (small batches) for new templates or audiences.
- Monitor API responses and respect rate-limit headers; implement backoff strategies.
- Mask or avoid storing sensitive data (PII) in logs or reports in plain text.

## Testing
- Unit tests: run your language-specific test runner (e.g., `npm test` or `pytest`).
- Integration tests: configure a sandbox Nexus environment or use a mock server to validate request structure.
- Load tests: use small-scale batches and gradually increase concurrency while monitoring the API.

## Logging & troubleshooting
- Set `LOG_LEVEL` to `debug` or `trace` to see full request/response payloads — be careful with PII.
- Check rate-limit headers if you see 429 responses and reduce concurrency or add backoff.
- For authentication failures (401/403), verify `NEXUS_API_KEY` and `NEXUS_API_URL`.
- If many records fail validation, verify CSV headers and template variable names match.

## Contributing
Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Add tests where applicable.
4. Open a pull request describing your change.

Please include unit tests for new functionality and update this README when you add/change CLI flags or environment variables.

## Security
- Do not commit API keys or PII to the repository. Use environment variables or secure secrets management.
- Rotate API keys periodically.
- If you discover a security issue, open a private issue and mark it as security-sensitive.

## License
This project is provided under the MIT License. Replace or update the license as appropriate for your organization.

## Contact
For questions, issues, or feature requests:
- Open an issue in this repository: [Issues](https://github.com/jimhancs1/Nexus-bulk-messaging/issues)
- Author / Maintainer: jimhancs1
