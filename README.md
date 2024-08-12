# Projeto: ANKIVESP

## Descrição

Projeto para auxiliar no desempenho de absorção de conteúdos das aulas da UNIVESP, utilizando um sistema similar ao anki para revisão de questões referente às matérias.

## Tecnologias

PHP8.3, Laravel11, VUE3.

## Instalação:

### Linux
Abrir o terminal:
```bash
git clone https://github.com/fernando-fix/projeto-modelo.git &&
cd projeto-modelo &&
cp .env.example .env &&
composer install &&
php artisan key:generate &&
nano .env &&
php artisan migrate --force &&
php artisan db:seed &&
npm install &&
npm run build &&
code . &&
php artisan serve
```
Em outro terminal, se for alterar o projeto:
```bash
npm install
npm run dev
```

### Windows
Editar copiar manualmente o .env e editar no vscode
