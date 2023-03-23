# hm2ue_oo

## Installation

See [INSTALL.md](https://github.com/Digital-Media/hyp2ue_oo/blob/main/INSTALL.md)

## Exercise

1. See ./examples to get started.
2. Follow instructions in index.html and test it.
3. Follow instructions in ShowFormInput.php and test it.
4. Install database if necessary
5. Write content of $_POST sent by index.html to database onlineshop and read it from there and display result. @see examples/StoreFormInput.php for an example.

## Install or reinstall database onlineshop
```shell 
docker exec -it mariadb /bin/bash -c "mariadb -uonlineshop -pgeheim </src/onlineshop.sql"
```
## Connect to database via commandline.
```shell 
docker exec -it mariadb /bin/bash -c "mariadb -uonlineshop -pgeheim"
```