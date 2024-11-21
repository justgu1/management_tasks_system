<h1>TMS - Task Management System</h1>

<p>O <strong>TMS</strong> (Task Management System) é uma aplicação de gerenciamento de tarefas com autenticação de usuários. Os usuários podem criar, editar, excluir e visualizar tarefas, além de gerenciar suas próprias tarefas ou visualizar tarefas criadas por outros usuários (dependendo de seu nível de permissão). Administradores podem acessar todas as tarefas, enquanto usuários comuns só podem visualizar as suas.</p>

<h2>Funcionalidades</h2>
<h3>Autenticação e Autorização</h3>
<ul>
  <li>Cadastro de usuários.</li>
  <li>Login com autenticação via token usando Laravel Sanctum.</li>
  <li>Verificação de login do usuário em cada requisição.</li>
</ul>

<h3>Gerenciamento de Tarefas</h3>
<ul>
  <li>Criação de tarefas com título, descrição e status.</li>
  <li>Edição de tarefas (apenas para o autor ou administradores).</li>
  <li>Exclusão de tarefas (apenas para o autor ou administradores).</li>
  <li>Visualização de tarefas de um usuário ou de todos (para administradores).</li>
</ul>

<h3>Dashboard</h3>
<ul>
  <li>Exibição de gráficos para tarefas:</li>
  <ul>
    <li>Tarefas por autor.</li>
    <li>Distribuição de tarefas por status (pendente, em andamento, concluída).</li>
  </ul>
</ul>

<h3>Responsividade</h3>
<p>A interface é responsiva e otimizada para dispositivos móveis e desktops.</p>

<h2>Tecnologias</h2>
<h3>Frontend:</h3>
<ul>
  <li>Vue.js para a construção da interface.</li>
  <li>Chart.js para exibição de gráficos.</li>
  <li>Vuex (se necessário) para gerenciamento de estado.</li>
</ul>

<h3>Backend:</h3>
<ul>
  <li>Laravel para API.</li>
  <li>Sanctum para autenticação via token.</li>
  <li>PostgreSQL como banco de dados padrão (mas pode ser configurado para outros bancos como MySQL, SQLite, etc.).</li>
</ul>

<h3>Gerenciamento de Dependências:</h3>
<ul>
  <li>Composer para o Laravel.</li>
  <li>npm/yarn para o Vue.js.</li>
</ul>

<h2>Instalação</h2>
<h3>Backend (Laravel)</h3>
<pre><code>git clone https://github.com/justgu1/management_tasks_system.git
cd management_tasks_system</code></pre>
<p>Instale as dependências do Laravel:</p>
<pre><code>composer install</code></pre>

<p>Configure o <code>.env</code>:</p>
<pre><code>DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tms
DB_USERNAME=usuario
DB_PASSWORD=senha</code></pre>

<p>Gere a chave da aplicação:</p>
<pre><code>php artisan key:generate</code></pre>

<p>Execute as migrações:</p>
<pre><code>php artisan migrate</code></pre>

<p>(Opcional) Seed do banco de dados com alguns dados de teste:</p>
<pre><code>php artisan db:seed</code></pre>

<p>Execute o servidor:</p>
<pre><code>php artisan serve</code></pre>
<p>O backend estará rodando em <a href="http://localhost:8000">http://localhost:8000</a>.</p>

<h3>Frontend (Vue.js)</h3>
<p>Navegue até o diretório do frontend:</p>
<pre><code>cd frontend</code></pre>

<p>Instale as dependências do Vue.js:</p>
<pre><code>npm install</code></pre>

<p>Configure o arquivo de API (se necessário) para apontar para o backend correto:</p>
<pre><code>// api.js
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Ou a URL do seu backend
});</code></pre>

<p>Execute o frontend:</p>
<pre><code>npm run serve</code></pre>
<p>O frontend estará rodando em <a href="http://localhost:5173">http://localhost:5173</a>.</p>

<h2>Como Usar</h2>
<h3>Autenticação</h3>
<ul>
  <li><strong>Cadastro de Usuário:</strong> Para se registrar, envie um <code>POST</code> para <code>/api/register</code> com os dados necessários (nome, email, senha).</li>
  <li><strong>Login:</strong> Para fazer login, envie um <code>POST</code> para <code>/api/login</code> com o email e senha. O backend retornará um token que deve ser armazenado no <code>localStorage</code>.</li>
  <li><strong>Logout:</strong> Envie um <code>POST</code> para <code>/api/logout</code> com o token de autenticação para deslogar.</li>
</ul>

<h3>Gerenciamento de Tarefas</h3>
<ul>
  <li><strong>Criar Tarefa:</strong> Envie um <code>POST</code> para <code>/api/task</code> com os dados da tarefa.</li>
  <li><strong>Editar Tarefa:</strong> Envie um <code>PUT</code> para <code>/api/task/{id}</code> com os dados atualizados.</li>
  <li><strong>Excluir Tarefa:</strong> Envie um <code>DELETE</code> para <code>/api/task/{id}</code> para deletar uma tarefa.</li>
  <li><strong>Visualizar Tarefas:</strong> Envie um <code>GET</code> para <code>/api/task</code> para listar as tarefas do usuário autenticado.</li>
</ul>

<h2>Estrutura do Banco de Dados</h2>
<h3>Tabela tasks:</h3>
<table border="1">
  <thead>
    <tr>
      <th>Nome do Campo</th>
      <th>Tipo</th>
      <th>Descrição</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>id</td>
      <td>int</td>
      <td>ID da tarefa (chave primária)</td>
    </tr>
    <tr>
      <td>title</td>
      <td>string</td>
      <td>Título da tarefa</td>
    </tr>
    <tr>
      <td>description</td>
      <td>text</td>
      <td>Descrição da tarefa</td>
    </tr>
    <tr>
      <td>status</td>
      <td>string</td>
      <td>Status da tarefa (pendente, em andamento, concluída)</td>
    </tr>
    <tr>
      <td>author</td>
      <td>int</td>
      <td>ID do usuário autor da tarefa</td>
    </tr>
    <tr>
      <td>created_at</td>
      <td>timestamp</td>
      <td>Data e hora de criação</td>
    </tr>
    <tr>
      <td>updated_at</td>
      <td>timestamp</td>
      <td>Data e hora de última atualização</td>
    </tr>
  </tbody>
</table>

<h3>Tabela users:</h3>
<table border="1">
  <thead>
    <tr>
      <th>Nome do Campo</th>
      <th>Tipo</th>
      <th>Descrição</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>id</td>
      <td>int</td>
      <td>ID do usuário (chave primária)</td>
    </tr>
    <tr>
      <td>name</td>
      <td>string</td>
      <td>Nome do usuário</td>
    </tr>
    <tr>
      <td>email</td>
      <td>string</td>
      <td>Email do usuário (único)</td>
    </tr>
    <tr>
      <td>password</td>
      <td>string</td>
      <td>Senha criptografada do usuário</td>
    </tr>
    <tr>
      <td>created_at</td>
      <td>timestamp</td>
      <td>Data e hora de criação</td>
    </tr>
    <tr>
      <td>updated_at</td>
      <td>timestamp</td>
      <td>Data e hora de última atualização</td>
    </tr>
  </tbody>
</table>
