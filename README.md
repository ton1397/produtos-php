## Clonando e Configurando seu Projeto PHP

### Passo 1: Clonando o Repositório GitHub
**O que é clonar?** É criar uma cópia idêntica de um repositório remoto (no GitHub, por exemplo) para o seu computador.

1. **Obtenha a URL do repositório:**
   * Acesse a página do repositório no GitHub.
   * Procure por um botão ou link com o texto "Code" ou "Código".
   * Clique na opção "HTTPS". A URL será copiada para a área de transferência.

2. **Abra seu terminal ou prompt de comando:**
   * Navegue até o diretório onde deseja salvar o projeto clonado.

3. **Execute o comando de clonagem:**
   * Cole a URL copiada e execute o seguinte comando:
     ```bash
     git clone https://github.com/ton1397/produtos-php.git
     ```

### Passo 2: Criando o Banco de Dados
**Crie um banco de dados com o nome especificado no arquivo `Database.sql`**. Normalmente, esse nome está definido no próprio script SQL.

1. **Acesse seu painel de controle do banco de dados:**
   * Utilize ferramentas como phpMyAdmin, Workbench ou o terminal do seu banco de dados.

2. **Crie um novo banco de dados:**
   * Informe o nome do banco de dados (por exemplo, `crud_produtos`).

3. **Importe o script SQL:**
   * Localize o arquivo `src/Model/DB/Database.sql` no diretório do seu projeto clonado.
   * Importe o conteúdo desse arquivo para o banco de dados recém-criado.

### Passo 3: Configurando o Arquivo de Configuração
**O arquivo `config/Config.php` contém as informações necessárias para conectar sua aplicação ao banco de dados.**

1. **Edite o arquivo `config/Config.php`:**
   * Abra o arquivo usando um editor de texto.

2. **Preencha as credenciais do seu banco de dados:**
   * Substitua os valores entre chaves por suas informações:
     * `DB_HOST`: Endereço do servidor do banco de dados.
     * `DB_PORT`: Porta do banco de dados.
     * `DB_DATABASE`: Nome do banco de dados que você acabou de criar.
     * `DB_USER`: Nome de usuário do banco de dados.
     * `DB_PASS`: Senha do banco de dados.

### Passo 4: Executando a Aplicação
**Agora que o projeto está configurado, você pode iniciar o servidor da sua aplicação.**

1. **Navegue até o diretório raiz do projeto:**
   * Abra seu terminal ou prompt de comando e navegue até o diretório onde você clonou o projeto.

2. **Inicie o servidor:**
   * A forma de iniciar o servidor varia dependendo do servidor web que você está utilizando (Apache, Nginx, etc.). Consulte a documentação do seu servidor web para obter instruções específicas.

   **Exemplo para um servidor PHP embutido:**
   ```bash
   php -S localhost:8000
