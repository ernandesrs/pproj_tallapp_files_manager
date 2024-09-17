# TALLAPP FILES MANAGER

Este é um simples gerenciador de arquivos para o [TALLAPP](https://github.com/ernandesrs/pproj_tallapp). Ele possui recursos para listagem, edição, exclusão e upload de arquivos.

Este pacote foi criado visando o estudo de criação de pacotes Laravel, e foi criado para a integração com o [TALLAPP](https://github.com/ernandesrs/pproj_tallapp).

# REQUISITOS

- TALLAPP

# INSTALAÇÃO

1. Instale o pacote:

> composer require ernandesrs/tallapp-files-manager

# CONFIGURAÇÃO

1. O pacote possui classes Tailwind que podem precisar ser 'enxergadas' pelo Tailwind do projeto que utilizará o pacote, por tanto é preciso publicar as views e configurar:

- Publique as views:

> php artisan vendor:publish --tag=tallapp-files-manager-views

- Abra o arquivo *tailwind.config.js*, e adicione:

```js

// ...
content: [
    ...,
    
    './resources/vendor/ernandesrs/tallapp-files-manager/**/*.php',
],
// ...

```

3. Há outros arquivos que você pode querer publicar:

> php artisan vendor:publish --tag=tallapp-files-manager-config

> php artisan vendor:publish --tag=tallapp-files-manager-lang

4. Agora você já pode usar o componente:

```php

<livewire:files-manager />

```

# AUTORIZAÇÕES
Você pode querer controlar as ações dos usúarios sobre os arquivos, para isso você pode criar uma [Policy](https://laravel.com/docs/11.x/authorization#writing-policies) normalmente e defini-lo no arquivo de configurações.

1. Publique o arquivo de configuração:

> php artisan vendor:publish --tag=tallapp-files-manager-config

2. Em *policy*, adicione a classe da sua policy:

```php

return [
    // ...

    /**
     *
     * Policy class containing this default Laravel Policy methods:
     * viewAny:
     * view:
     * create:
     * update:
     * delete:
     *
     */
    'policy' => \Your\Policy\Namespace\Class::class,
];

```

Para mais informações, abrar o arquivo de configuração.

# TRADUÇÕES

Você pode querer traduzir os textos dos botões, alertas, etc, para isso você precisa:

1. Publicar os arquivos de idioma:

> php artisan vendor:publish --tag=tallapp-files-manager-lang
