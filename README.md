<h1> nextPlay 🎮 </h1>

Projeto final do curso Técnico em Informática do UNASP Hortolândia - 2024

<hr/>

<h2>Sobre o projeto</h2>
O NextPlay é uma rede social voltada para gamers, desenvolvida com foco em conectar jogadores que buscam companheiros para partidas online.  
O sistema foi construído em PHP com integração ao MySQL para armazenamento e gerenciamento dos dados. O GitHub foi utilizado apenas para hospedar o projeto pronto, após sua conclusão.
<br><br>

Funções que os usuários podem desempenhar:
<ul>
  <li>
    Criar um ambiente onde usuários possam se cadastrar, personalizar perfis e interagir com outros gamers.
  </li>
  <li>
    Permitir a publicação de postagens, com suporte a curtidas, comentários e interação entre jogadores.
  </li>
  <li>
    Disponibilizar chat privado entre usuários para facilitar a comunicação durante a organização de partidas.
  </li>
  <li>
    Implementar gerenciamento de amizades e possibilidade de encontrar jogadores para jogos específicos.
  </li>
  <li>
    Proporcionar uma experiência social semelhante a uma comunidade gamer, com foco em engajamento e usabilidade.
  </li>
</ul>

<hr/>

<h2>Como rodar localmente</h2>
Para executar o NextPlay no seu computador, siga os passos abaixo:

<ol>
  <li>
    <b>Instale o XAMPP</b> (ou outro servidor PHP) com Apache e MySQL, e também o <b>Composer</b>.
  </li>
  <li>
    <b>Copie os arquivos do projeto</b> para a pasta do servidor local:
    <ul>
      <li>Exemplo no XAMPP: <code>C:\xampp\htdocs\nextPlay</code></li>
    </ul>
  </li>
  <li>
    <b>Inicie o Apache e o MySQL</b> pelo XAMPP Control Panel.
  </li>
  <li>
    <b>Crie o banco de dados</b> no phpMyAdmin:
    <ul>
      <li>Nome do banco sugerido: <code>nextplay</code></li>
      <li>Importe o arquivo SQL do projeto, caso exista, ou crie manualmente as tabelas.</li>
    </ul>
  </li>
  <li>
    <b>Configure a conexão com o banco</b> em <code>config.php</code> ou <code>db.php</code>:
    <pre><code>$host = "localhost";
$user = "root";       // padrão XAMPP
$pass = "";           // padrão XAMPP
$db   = "nextplay";</code></pre>
  </li>
  <li>
    <b>Instale as dependências do PHP</b> usando o Composer:
    <pre><code>cd C:\xampp\htdocs\nextPlay
composer install</code></pre>
    Isso irá instalar o PHPMailer e gerar o autoload automático das classes.
  </li>
  <li>
    <b>Permissões de pastas</b>: verifique se as pastas <code>uploads/</code>, <code>profile_pics/</code> e <code>files/</code> permitem escrita.
  </li>
  <li>
    <b>Abra o navegador</b> e acesse:
    <pre><code>http://localhost/nextPlay/</code></pre>
    O sistema deve carregar normalmente.
  </li>
  <li>
    <b>Configuração de e-mails</b> (opcional para testes):
    <ul>
      <li>Configure o PHPMailer no arquivo responsável pelo envio de e-mails com SMTP ou use um servidor de testes local como o <a href="https://github.com/mailhog/MailHog">MailHog</a>.</li>
    </ul>
  </li>
</ol>
