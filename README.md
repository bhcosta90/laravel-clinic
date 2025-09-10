Projeto Clinic – Guia de Instalação e Inicialização

Este documento descreve, de forma objetiva, como preparar o projeto localmente e iniciar a aplicação.

Requisitos básicos
- PHP 8.x com extensões comuns do Laravel (pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo)
- Composer
- Banco de dados (MySQL/MariaDB ou PostgreSQL)
- Node.js e npm (opcional, apenas se for compilar os assets)

Passo a passo de instalação
1) Clonar o repositório
- git clone git@github.com:bhcosta90/laravel-clinic.git
- cd laravel-clinic

2) Variáveis de ambiente
- Copie o arquivo de exemplo: cp .env.example .env
- Edite o .env e configure a conexão com o banco de dados (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)

3) Instalar dependências
- composer install
- npm install

4) Gerar a chave da aplicação
- php artisan key:generate

5) Criar link de storage (recomendado)
- php artisan storage:link

6) Preparar o banco de dados (comandos principais para iniciar)
- php artisan migrate
- php artisan db:seed
- composer run reset

Observações sobre os comandos acima
- php artisan migrate: Executa as migrações e cria as tabelas no banco configurado no .env.
- php artisan db:seed: Popula o banco com dados iniciais definidos nos seeders do projeto.
- composer run reset: Executa o script "reset" definido no composer.json. Utilize-o conforme a necessidade do projeto (por exemplo, para reiniciar o estado do banco/dados de desenvolvimento). Caso não esteja claro o objetivo, verifique o composer.json.

Executar a aplicação
- Servidor embutido do PHP/Laravel: composer run dev
- URL: http://demo.localhost:8600
- Usuário: demo@test.com
- Senha: password

Observação: Caso o endereço demo.localhost não resolva no seu ambiente, ajuste seu proxy/hosts (por exemplo, adicionando uma entrada no /etc/hosts ou configurando o servidor local) para apontar demo.localhost para 127.0.0.1 e garantir que a porta 8600 esteja mapeada corretamente.

Solução de problemas
- Erros de conexão com o banco: confira as credenciais no .env e se o serviço do banco está ativo.
- Permissões de pasta: garanta permissão de escrita em storage/ e bootstrap/cache/.
- Cache de configuração: se ajustar variáveis e não refletir, rode php artisan config:clear e php artisan cache:clear.

Informações adicionais
- Testes: vendor/bin/pest (se houver testes configurados)

Dúvidas
Se algo não estiver claro, consulte o arquivo composer.json (scripts), as migrações/seeds em database/ e as rotas em routes/ para entender o fluxo de inicialização do projeto.
