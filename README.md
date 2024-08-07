
# LojaCorr FS PL

Projeto Laravel


## Ambiente

- Aplicar env.example

- Para levantar o ambiente, rode os seguintes comandos:

```
  docker-compose build --no-cache
```

```
  docker-compose up -d
```

```
  docker-compose exec app bash
```

```
  composer install
```

```
  php artisan config:cache
```

```
  php artisan route:cache
```

```
  php artisan migrate
```

```
  php artisan db:seed UserSeeder
```


## Postman

https://www.postman.com/warped-crater-633576/workspace/lojacorr/collection/31942382-a98b4524-d4c8-4839-93ae-a10a9150cfd9?action=share&creator=31942382


## Passo a passo

- Realizar autenticação
- Criar as categorias
- Criar as subcategorias

## Arquitetura

Quis trazer a base do problema com uma visão de solução um pouco diferente do que foi solicitado.

Baseado na arquitetura Repository, tambem trouxe apenas um model e uma tabela que contempla tanto a Categoria como a Subcategoria, simplificando a complexidade.
## Portas

:80 - web

:8080 - phpmyadmin
```
root
root
```