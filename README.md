# Atlvs TaskFlow

O **Atlvs TaskFlow** é uma solução profissional de gerenciamento de projetos e tarefas desenvolvida em PHP com o framework Laravel. Projetada para equipes que buscam controle total sobre suas responsabilidades, a aplicação permite organizar fluxos de trabalho de forma clara e eficiente.

## 🚀 Funcionalidades Principais

- **Gestão de Projetos**: Centralize todos os seus sites e desenvolvimentos em um só lugar.
- **Controle de Tarefas**:
    - **Prioridades**: Defina o que é urgente com níveis Baixa, Média e Alta.
    - **Status Dinâmicos**: Acompanhe o progresso com status como *Pendente*, *Em Andamento*, *Travado* e *Concluído*.
    - **Atribuição**: Designe responsáveis específicos para cada tarefa.
- **Sistema de Convites**: Comece com um administrador e convide sua equipe conforme necessário.
- **Interface Moderna**: Construída com Tailwind CSS para uma experiência de usuário limpa e profissional.

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 8.1+ & Laravel 10
- **Frontend**: Blade Templates & Tailwind CSS
- **Banco de Dados**: SQLite (configuração inicial para facilidade de uso)
- **Autenticação**: Laravel Breeze

## 📋 Instruções de Instalação

Para rodar o projeto localmente, siga os passos abaixo:

1. **Clonar o Repositório**:
   ```bash
   git clone https://github.com/MauricioLopes-Dev/Atlvs-TaskFlow.git
   cd Atlvs-TaskFlow
   ```

2. **Instalar Dependências**:
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configurar o Ambiente**:
   - O arquivo `.env` já está pré-configurado para usar SQLite.
   - Certifique-se de que o arquivo `database/database.sqlite` existe:
     ```bash
     touch database/database.sqlite
     ```

4. **Executar Migrations e Seeders**:
   ```bash
   php artisan migrate --seed
   ```
   *Nota: O seeder criará um usuário administrador inicial:*
   - **Email**: `admin@empresa.com`
   - **Senha**: `senha123`

5. **Iniciar o Servidor**:
   ```bash
   php artisan serve
   ```
   Acesse em: `http://localhost:8000`

## 🤝 Contribuição

Este projeto foi desenvolvido para uso interno da empresa. Sinta-se à vontade para expandir as funcionalidades conforme a necessidade da sua equipe de 4 pessoas.

---
Desenvolvido com foco em produtividade e colaboração.
