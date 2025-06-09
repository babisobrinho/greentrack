# GreenTrack 🌱

O GreenTrack é uma aplicação web que permite aos utilizadores registar e acompanhar as suas ações sustentáveis, ver o seu impacto ambiental e aceder a conteúdos educativos sobre sustentabilidade. O projeto inclui uma área de administrador para gestão de utilizadores e conteúdos.

Objetivos:
- Promover a consciencialização ambiental
- Facilitar o acompanhamento de hábitos sustentáveis
- Criar uma comunidade engajada em práticas ecológicas
- Fornecer dados e estatísticas sobre impacto ambiental

## 💻 Funcionalidades

### Para Membros

- **Registo e Autenticação**: Sistema seguro de criação de conta e login
- **Dashboard Pessoal**: Ver estatísticas e progresso individual
- **Registo de Ações**: Adicionar ações sustentáveis com cálculo de impacto
- **Conteúdos Educativos**: Acesso a artigos e dicas sobre sustentabilidade
- **Sistema de Votação**: Avaliar conteúdos com likes e dislikes
- **Gestão de Perfil**: Editar informações pessoais
- **Histórico**: Visualizar todas as ações registadas

### Para Administradores

- **Dashboard**: Estatísticas globais da plataforma
- **Gestão de Utilizadores**: CRUD de contas de utilizador
- **Gestão de Conteúdos**: Criar, editar e eliminar artigos educativos
- **Relatórios**: Ver métricas e dados analíticos
- **Moderação**: Controlo de conteúdos e atividades dos utilizadores

## 🛠️ Tecnologias Utilizadas

- **HTML5** - Estrutura semântica
- **CSS3** - Estilos
- **JavaScript ES6+** - Interatividade
- **Bootstrap 5.3.2** - Framework responsivo de CSS
- **PHP 8.3+** - Linguagem de programação
- **MySQL 8.0+** - Base de dados
- **PDO** - Interface de base de dados

### Bibliotecas e Ferramentas
- **Iconify (Solar Icons)** - Ícones
- **Google Fonts** - Tipografia (Poppins, Montserrat)
- **Chart.js** - Gráficos e visualizações

## 📁 Estrutura do Projeto

```
greentrack/
├── admin/                    # Área do Admin
│   ├── dashboard.php         # Dashboard do admin
│   ├── utilizadores.php      # Gestão de utilizadores
│   ├── conteudos.php         # Gestão de conteúdos
│   └── ...
├── user/                     # Área do utilizador
│   ├── dashboard.php         # Dashboard do utilizador
│   ├── perfil.php            # Gestão de perfil
│   ├── conteudos.php         # Ver conteúdos
│   └── ...
├── includes/
│   ├── auth.php              # Autenticação
│   ├── db.php                # Conexão à BD
│   ├── functions.php         # Funções auxiliares
│   └── ...
├── layouts/
│   ├── header.php            # Cabeçalho
│   └── footer.php            # Rodapé
├── assets/
│   ├── css/                  # Folhas de estilo
│   ├── js/                   # Scripts JavaScript
│   └── img/                  # Imagens
├── db/
│   ├── greentrack.sql        # Base de dados
│   └── criar_greentrack.sql  # Estrutura da BD
├── config.php                # Configurações
├── index.php                 # Página inicial
├── login.php                 # Página de login
├── registo.php               # Página de registo
└── sobre.php                 # Página sobre
```

## 🗄️ Base de Dados

### Tabelas Principais

- **utilizadores** - Gestão de contas de utilizador
- **acoes_sustentaveis** - Registo de ações sustentáveis
- **conteudos** - Artigos e conteúdos educativos
- **votos** - Sistema de votação em conteúdos

### Relacionamentos

- Utilizadores → Ações Sustentáveis (1:N)
- Utilizadores → Conteúdos (1:N)
- Utilizadores → Votos (1:N)

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.3 ou superior
- MySQL 8.0 ou superior
- Servidor web (Apache/Nginx)
- phpMyAdmin (opcional)

### Passos de Instalação

1. **Clone ou descarregue o projeto**

```bash
   git clone https://github.com/babisobrinho/greentrack.git
   cd greentrack
```

2. **Configure a base de dados**
- Crie uma base de dados MySQL chamada `greentrack`
- Importe o ficheiro `db/greentrack.sql`

```sql
   CREATE DATABASE greentrack;
   USE greentrack;
   SOURCE db/greentrack.sql;
```

3. **Configure as credenciais**
   - Edite o ficheiro `config.php`
   - Atualize as credenciais da base de dados

```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'greentrack');
   define('DB_USER', 'seu_usuario');
   define('DB_PASS', 'sua_password');
```

4. **Configure o servidor web**
- Aponte o document root para a pasta do projeto
- Certifique-se de que o PHP está ativo
- Configure as permissões necessárias

5. **Aceda à aplicação**
- Abra o browser e navegue para `http://localhost/greentrack`
- Crie uma conta ou use as credenciais de teste

### Credenciais de Teste

**Administrador:**
- Email: admin@greentrack.pt
- Password: 12345678

**Membro:**
- Email: maria.santos1@email.com
- Password: 12345678

## 🔒 Segurança

### Medidas Implementadas
- **Hash de Passwords**: Utilização de `password_hash()` e `password_verify()`
- **Prepared Statements**: Prevenção de SQL injection
- **Proteção CSRF**: Tokens anti-CSRF em formulários
- **Sanitização**: Limpeza de inputs com `htmlspecialchars()`
- **Gestão de Sessões**: Configurações seguras e timeout automático
- **Validação**: Validação server-side de todos os dados

### Configurações de Segurança

- Cookies HTTPOnly ativados
- Sessões seguras em HTTPS
- Headers de segurança configurados
- Separação de credenciais

## 🎨 Design System

### Paleta de Cores

- **Verde Primário**: #2ecc71
- **Verde Escuro**: #27ae60
- **Verde Claro**: #a9dfbf
- **Azul**: #3498db
- **Cinzentos**: #f8f9fa até #212529

### Tipografia & Ícones

- **Primária**: Poppins (corpo do texto)
- **Secundária**: Montserrat (títulos)
- **Biblioteca**: Solar Icons via Iconify

## 📝 Licença

Este projeto está sob a licença MIT.

## 👩‍💻 Créditos

**Babi Sobrinho**

**Desenvolvido com 💚 para um futuro mais sustentável**

