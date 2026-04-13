# Template WordPress

1. Criar um novo repositório usando este como template
1. Fazer o clone do repositório
1. Baixar o WordPress
1. Renomear a pasta do tema (em `wp-content/themes/nome-do-tema`)
1. Alterar `nome-do-tema` para o novo nome em `.gitignore`
1. Instalar Node e suas dependências:
   ```bash
   cd wp-content/themes/nome-do-tema
   nvm install
   npm install
   npm run watch
   ```

## No wp-admin

1. Ativar o tema
1. Instalar e ativar ACF
