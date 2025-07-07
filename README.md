# 🧑‍💻 Sistema de Perfil de Usuário - Desafio Técnico - Sync360.io

Este projeto é um sistema de gerenciamento de usuários com interface para exibição, edição e cadastro de perfis. Desenvolvido em PHP com MySQL e Bootstrap.

## ✨ Funcionalidades

- Login e logout de usuários
- Exibição do perfil (inclui foto, nome, idade, endereço, biografia, CPF e e-mail);
- Edição de perfil pessoal (com upload de nova imagem de perfil);
- Edição de perfil geral(somente admin);
- Cadastro de novos usuários;
- Listagem de todos os usuários cadastrados;
- Controle de acesso (usuário normal e admin);
- Mensagens de sucesso e erro após ações (cadastro, exclusão, edição);
- Estilização com Bootstrap (responsivo);

## 📌 Recursos Técnicos Utilizados

- Uso de `SESSION` para controle de login e identificação do usuário logado;
- Métodos `POST` para envio de formulários (cadastro, edição, login);
- Uso de `GET` para redirecionamentos e passagem de parâmetros na página de alterar User;
- Validação de campos (ex: nome, e-mail, CPF, imagem);
- Upload de imagem com verificação de tipo e salvamento seguro;
- Redirecionamento e proteção de páginas com base no tipo de usuário;

## 🛠️ Tecnologias

- PHP;
- MySQL;
- HTML / CSS;
- Bootstrap;
- Estrutura modular (MVC simplificado);

## 🗂️ Estrutura de diretórios (resumida)

src/
├── Conexao/
│ └── Conexao.php
│ └── ...
├── Controller/
│ └── ConUser.php
├── Model/
│ └── User.php
├── View/
│ └── imgperfil/ (imagens de perfil)
│ └── img/ (imagens icones)
│ └── header.php
│ └── index.php (home)
│ └── login.php
│ └── sair.php
│ └── perfil.php
│ └── AlterarPerfil.php (específico)
│ └── VisualizarUser.php
│ └── AlterarUser.php (todos)
│ └── CadastrarUser.php

## 🧪 Como rodar o projeto

### Site

1. Acesse pelo navegador:
https://iuryraminelli.com/Sync360/Home

### XAMPP
1. Clone o repositório:

   git clone https://github.com/IuryRaminelli/Sync360.git

2. Importe o banco de dados:

    Use o arquivo sync360.sql na pasta Conexao

3. Acesse pelo navegador:

    http://localhost/Sync360/Home

## 👤 Usuários padrão para teste

| Tipo   | Login                     | Senha    |
| -----  | -------                   | -------- |
| Admin  | raminelliiury4@gmail.com  | 123      |
| Normal | raminelliiury5@gmail.com  | 123      |

## 📷 Imagens e uploads

- As imagens de perfil são armazenadas em src/View/imgperfil/
- Upload seguro com validação básica