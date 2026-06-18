# Bolão 2026 🏆

Bem-vindo ao repositório do **Bolão 2026**, um sistema desenvolvido para gerenciar palpites e pontuações para a Copa do Mundo de 2026.

## 🚀 Sobre o Projeto

Este projeto foi criado com o objetivo de facilitar a organização de bolões entre amigos, empresas ou grupos, permitindo que os usuários façam seus palpites nos jogos da Copa do Mundo e acompanhem suas pontuações em tempo real.

O sistema é desenvolvido utilizando o framework **Laravel**, garantindo robustez e escalabilidade.

## 🛠️ Tecnologias Utilizadas

- **PHP**: Linguagem de programação principal.
- **Laravel**: Framework PHP utilizado como base do projeto.
- **MySQL/PostgreSQL**: Banco de dados relacional.
- **FlagCDN**: Integração para exibição automática das bandeiras das seleções baseada na sigla do país.

## ⚙️ Funcionalidades

- **Autenticação Completa**: Registro, login, recuperação de senha e verificação de e-mail.
- **Gestão de Times**: Cadastro das seleções da Copa do Mundo de 2026 (EUA, México, Canadá, Brasil, etc.).
- **Visualização de Bandeiras**: As bandeiras são geradas dinamicamente através da API do FlagCDN.
- **Internacionalização**: Suporte para Português (pt-BR).

## 📦 Como Rodar o Projeto Localmente

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/bolao2026.git
   cd bolao2026
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure o ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Banco de Dados:**
   Crie um banco de dados e configure as credenciais no arquivo `.env`. Em seguida, execute as migrações e os seeders para popular os times:
   ```bash
   php artisan migrate --seed
   ```

5. **Inicie o servidor:**
   ```bash
   php artisan serve
   ```


## 👥 Equipe e Contribuições

* **[@mir4310](https://github.com/mir4310)**
  * **Papel:** UI/UX Designer & Lead Developer
  * **Contribuição:** Responsável pelo design visual da interface (arquitetura/desenho) e pelo desenvolvimento de toda a lógica e programação principal do projeto.

* **[@arthurbentivenha](https://github.com/arthurbentivenha)**
  * **Papel:** DevOps - Infraestrutura
  * **Contribuição:** Responsável pela configuração do ambiente de implantação (deploy), pipelines de CI/CD e gerenciamento dos servidores/infraestrutura na nuvem.

* **[@luizprimati](https://br.linkedin.com/in/luizprimati)**
  * **Papel:** ntegration Specialist
  * **Contribuição:** Responsável pela arquitetura e desenvolvimento da integração de dados e comunicação com os placares em tempo real (APIs).


## 📝 Licença

Este projeto está sob a licença MIT.
