# pdi-with-okr
Project using OKRs on PDI

## Requirements
- Docker
- Make
- Hosts file (add the following to your hosts file: 127.0.0.1 laravel.test)

## Development
After downloading the project, run the following command to install the dependencies:
```bash
make 
```
Note: it will take a while to install the dependencies and start the containers.
So now, just access the application at http://laravel.test

On next time, you can start the containers with the following command:
```bash
make up
```

After that, open new terminal and run the following command to hot reload the application:
```bash
make watch
```

## Testing

```bash
make check
```

## Stopping the containers

```bash
make down
```

Note: For more commands, check the Makefile.

