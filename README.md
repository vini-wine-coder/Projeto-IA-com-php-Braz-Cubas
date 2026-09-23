# Projeto AI PEEP

> Projeto de prova de conceito (POC) desenvolvido como primeiro teste de integração entre uma interface web em PHP e a API de IA do Google Gemini.

Este repositório representa uma implementação inicial, funcional e experimental, com foco em validar a comunicação entre o frontend e um modelo de linguagem em um ambiente simples e didático. A intenção é demonstrar a viabilidade do conceito, sem pretender ser uma solução completa de produção.

## Visão geral

O projeto consiste em uma interface de chat web que envia mensagens para um backend em PHP e retorna respostas geradas por uma IA. A aplicação utiliza a API Gemini para processar as mensagens do usuário e responder em tempo real.

## Objetivo

Validar, de forma prática, a integração entre:

- PHP no backend
- JavaScript no frontend
- API de IA do Google Gemini
- Interface de chat simples em navegador

## Funcionalidades

- Chat interativo em interface web
- Envio de mensagens do usuário para o backend
- Processamento da mensagem pela API Gemini
- Retorno da resposta em formato JSON
- Tratamento básico de erros e retries em caso de falha temporária
- Estrutura leve e fácil de entender para aprendizado e testes

## Estrutura do projeto

```text
.
├── index.php          # Interface principal da aplicação
├── chat.php           # Backend responsável pela comunicação com a IA
├── style.css          # Estilos da interface
├── assets/            # Arquivos visuais e recursos do front-end
├── README.md          # Documentação do projeto
└── .gitignore         # Arquivos ignorados pelo Git (se existir no repositório)
```

## Tecnologias utilizadas

- PHP
- JavaScript
- HTML5 / CSS3
- API Gemini (Google Generative AI)
- cURL para requisições HTTP

## Pré-requisitos

Antes de executar o projeto, certifique-se de que o ambiente tenha:

- PHP instalado
- Extensão cURL habilitada
- Navegador moderno
- Chave de API da Gemini configurada

## Configuração

1. Acesse o arquivo `chat.php`.
2. Localize a seguinte seção:

```php
$model   = 'gemini-2.0-flash';
$apiKey  = ''; //KEY
```

3. Informe sua chave da API do Google Gemini.
4. Salve o arquivo.

## Como executar

Na raiz do projeto, execute:

```bash
php -S localhost:8000
```

Depois, abra no navegador:

```text
http://localhost:8000/index.php
```

## Fluxo de funcionamento

1. O usuário digita uma mensagem na interface.
2. O frontend envia a mensagem para `chat.php` via requisição POST.
3. O backend monta a requisição para a API Gemini.
4. A resposta da IA é recebida e convertida em JSON.
5. A interface exibe a resposta do modelo no chat.

## Observações importantes

Este projeto foi desenvolvido como um primeiro teste de conceito e prova de funcionalidade. Em outras palavras, ele foi pensado para validar a integração e demonstrar o comportamento inicial do sistema, e não como uma solução pronta para ambiente de produção.

Alguns pontos que ainda podem ser melhorados em versões futuras:

- segurança na manipulação da chave da API
- armazenamento de configurações em variáveis de ambiente
- tratamento mais robusto de erros e validações
- interface mais sofisticada e amigável
- arquitetura melhor estruturada para expansão
- autenticação e logs de uso

## Status do projeto

Status: prova de conceito / primeira versão experimental

## Conclusão

Este repositório representa uma etapa inicial de aprendizado e validação técnica, servindo como base para futuras melhorias, testes e evoluções do projeto. O objetivo principal foi confirmar que a comunicação entre PHP e IA pode funcionar de forma simples e funcional em um cenário de protótipo.

Se você estiver testando este projeto, pode utilizá-lo como ponto de partida para desenvolver uma versão mais robusta, segura e escalável.
