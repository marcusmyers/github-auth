# github-auth

This is a php port of Chris Hunt's
[github-auth](https://github.com/chrishunt/github-auth).  I did this
mainly because I have been writing a php command line application and
needed something like it.

### Pairing with strangers has never been so good.

**github-auth** allows you to quickly pair with anyone who has a GitHub
account
by adding and removing their public ssh keys from your
[`authorized_keys`](http://en.wikipedia.org/wiki/Ssh-agent) file.

## Install
`composer global require "marcusmyers/github-auth=~1.0.0"`

Make sure to place the ~/.composer/vendor/bin directory in your `PATH` so the `gh-auth` executable is found when you run the `gh-auth` command in your terminal.

## Ussage

### Adding a user
```bash
$ gh-auth add marcusmyers
Successfully added marcusmyers to your authorized keys file
```

### Removing a user
```bash
$ gh-auth remove marcusmyers
Removed 2 keys from your authorized_keys file
``` 

### Listing users
```bash
$ gh-auth list-users
marcusmyers
```
