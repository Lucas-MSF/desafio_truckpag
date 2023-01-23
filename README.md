# Projeto Open Food Facts

### O projeto tem como objetivo dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que eles possam revisar de maneira rápida a informação nutricional dos alimentos que os usuários publicam pela aplicação móvel.

# Instruções para executar

Foi usado Laravel e MySQL nesse projeto, junto com testes usando PHPUnit.

* Primeiro é preciso criar um arquivo .env e copiar o conteúdo do .env.example para .env.

* Configure o arquivo .env com as configurações do banco de dados.
Exemplo:
```sh
DB_CONNECTION=mysql
DB_HOST=(ip database)
DB_PORT=(porta database)
DB_DATABASE=(seu database)
DB_USERNAME=(seu usuario)
DB_PASSWORD=(sua senha)
```
Mude essas configurações de acordo com as credenciais.
* Crie o banco de dados com o mesmo nome do DB_DATABASE do do arquivo .env.

* Instale as dependencias com o comando abaixo:

```sh
$ composer install
```
* Gere a key do projeto com o comando.

```sh
$ php artisan key:generate
```
* Migre o banco de dados
```sh
$ php artisan migrate
```
# Instruções para configurar o CRON em sua maquina

* Em seu terminal linux insira o seguinte comando:
  ```
    sudo nano /etc/crontab
  ```
  
* Na ultima linha insira:

    ```
    0  3    * * *   root    cd (caminho onde está o seu projeto) && php artisan seedTables:add >> /dev/null 2>&1
    ```

* 
# Instruções para executar os testes

* Crie um arquivo chamado "databse.sqlite" dentro da diretório database.

* Faça uma copia da .env com o nome de .env.testing e sincronize com o database sqlite.
  
```sh
DB_CONNECTION=sqlite
DB_DATABASE=database/databse.sqlite
```

* Para executar os testes é só rodar o comando.

```sh
$ php artisan test --env=env.testing
```

# Endpoints

| Endpoint                             | Retorno                                                                                                                                                             | Parâmetros do body                               |
| ------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------ |
| GET /                                | Retorna detalhes da API, se conexão leitura e escritura com a base de dados está OK, horário da última vez que o CRON foi executado, tempo online e uso de memória. |                                                  |
| PUT /products/{codigo do produto}    | Retorna o produto com as alterações feita                                                                                                                           | (nome do campo que deseja alterar) : (alteração) |
| DELETE /products/{codigo do produto} | Retorna o produto no qual o status foi alterado para "trash"                                                                                                        |                                                  |
| GET /products/{codigo do produto}    | Retorna o produto compativel com o codigo enviado                                                                                                                   |                                                  |
| GET /products                        | Retorna todos os produtos cadastrados no banco de dados                                                                                                             |
|                                      |

