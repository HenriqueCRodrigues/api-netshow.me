<p align="center">
    <img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400">
    <img src="https://netshow.me/wp-content/uploads/2020/03/featured-image-site.gif" width="180"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


## Desafio Netshow.me: Soluções completas em vídeos online
Foi realizado a criação de uma API em laravel e o front em React<br>
Para emular o projeto, basta seguir os requisitos básico do Laravel 7.x, que se encontra no link: https://laravel.com/docs/7.x

Após o clone do projeto, basta entrar no projeto e seguir o procedimento abaixo<br>
<ul>
    <li>executar o comando "composer install"</li>
    <li>npm install</li>
    <li>executar o comando "git clone https://github.com/laradock/laradock.git"</li>
</ul>

Com isso, a API e o front direcionado na rota raiz ('/').<br>
A API utiliza o laradock para instanciar o docker

Para utilizar o Docker na api, entre na pasta laradock e execute o comando "sudo docker-compose up -d nginx mysql phpmyadmin".<br>
OBS: Após o git clone do laradock, deve-se configurar um arquivo .env dentro da pasta laradock, existe um arquivo .env.example para melhor entendimento.



#### Rotas da API

```
+--------+----------+-------------+----------------+----------------------------------------------+------------+
| Domain | Method   | URI         | Name           | Action                                       | Middleware |
+--------+----------+-------------+----------------+----------------------------------------------+------------+
|        | GET|HEAD | /           |                | Closure                                      | web        |
|        | POST     | api/contact | contacts.store | App\Http\Controllers\ContactController@store | api        |
+--------+----------+-------------+----------------+----------------------------------------------+------------+

```

#### / 
```
Rota do tipo GET, formulario para cadastrar informação de contato 
Exemplo do Response abaixo
```
<img src="https://i.imgur.com/ITaQvrw.png">
<br>

#### api/contact 
```
Rota do tipo POST, armazena a informação de contato 
Exemplo do Response abaixo
```
<img src="https://i.imgur.com/WkXl3Nu.png">
<br>

#### TDD
<img src="https://i.imgur.com/JzP4grb.png">
<br>


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
