<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

## DOCUMENTAÇÃO DA API - ENDPOINTS

      GET users/          http://localhost:8080/user/index
      - Descrição:          Lista todos os usuários da api


      POST users/         http://localhost:8080/user/create
      - Descrição:          Cadastra um usuário no sistema e ao cadastrar é gerado o token de acesso.
      - Exemplo:            {
                            "username": "user",
                            "password": "password"
                          }


      POST login/         http://localhost:8080/login/index
      - Descrição:          Realiza a autenticação de usuário já existente e é gerado um novo token de acesso.
      - Exemplo:            {
                            "username": "user",
                            "password": "password"
                          }


      GET client/         http://localhost:8080/client/index
      - Descrição:          Lista todos os clientes cadastrados na api, esse endpoint tem paginação, que pode ser consultada no exemplo abaixo. Para seu uso, é necessário colocar o token de acesso em Authorization, bearer  token.
      - Exemplo Paginação:  http://localhost:8080/client/index?page=2


      POST client/        http://localhost:8080/client/create
      - Descrição:          Realiza o cadastro de clientes na api. Para seu uso, é necessário colocar o token de acesso em Authorization, bearer  token.
      - Exemplo:            Campos obrigatórios (name, cpf, address, photo, sex). Fazer a requisição em body, form-data para incluir photo arquivo de imagem.


      GET product/        http://localhost:8080/product/index
      - Descrição:          Lista todos os produtos cadastrados na api, esse endpoint tem paginação e tem filtro pelo client_id, que pode ser consultada no exemplo abaixo. Para seu uso, é necessário colocar o token de acesso em Authorization, bearer  token.
      - Exemplo Paginação:  http://localhost:8080/product/index?page=2
      - Exemplo Filtro:  http://localhost:8080/product/index?client_id=2


      POST product/       http://localhost:8080/product/create
      - Descrição:          Realiza o cadastro de produtos na api. Para seu uso, é necessário colocar o token de acesso em Authorization, bearer  token.
      - Exemplo:            Campos obrigatórios (name, price, photo, client (id do cliente)). Fazer a requisição em body, form-data para incluir photo arquivo de imagem.

## REQUIREMENTS

Docker Desktop

## INSTALLATION

### Instalação e clonando repositório do git

```
git clone https://github.com/jefersoniw/avaliacao-tecnico-coalize.git
```

Após clonar o projeto do github. Ligar o docker desktop e dentro da pasta do projeto, no terminal cmd, executar o seguinte comando:

```
docker compose up -d
```

Esse comando irá instalar todo o ambiente necessário para o funcionamento da api. Agora precisamos instalar as dependência do nosso projeto com o composer que já vem instalado junto com o ambiente.

```
docker compose exec php bash
```

O comando acima irá abrir um terminal do container php/yii2 no qual você irá executar um comando php/composer para instalação das dependências do projeto.

```
composer install
```

Após finalizado, poderá fazer o teste da api. A api estará funcionando com o banco mysql e no endereço

```
http://localhost:8080
```
