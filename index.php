<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #7289DA;
            --secondary-color: #99AAB5;
            --background-color: #1e2124;
            --text-color: #FFFFFF;
            --accent-color: #43B581;
            --hover-color: #5865F2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: rgba(30, 33, 36, 0.9);
            position: fixed;
            width: 100%;
            padding: 15px;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .logo-link {
            text-decoration: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            color: #f0f1f2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn {
            background-color: var(--primary-color);
            color: var(--text-color);
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--hover-color);
            transition: background-color 0.3s ease;
        }

        /* Seção Hero */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px;
            position: relative;
            overflow: hidden;
            background-image: url('assets/img/player.jpg'); /* Define a imagem como background */
            background-size: cover;
            background-position: center;
            text-align: center; /* Centraliza o texto */
            color: #fff; /* Cor do texto para garantir visibilidade */
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Adiciona uma sobreposição escura */
            z-index: -1;
        }

        .hero-content {
            z-index: 1;
            max-width: 700px; /* Limita a largura do conteúdo para melhor visualização */
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
        }




        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Seção funcionalidades */
        .features {
            padding: 100px 0;
            text-align: center;
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            opacity: 0.05;
            z-index: -1;
        }

        .features h2 {
            font-size: 36px;
            margin-bottom: 50px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .feature-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        /* Seção do video */
        .demo {
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .demo-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .demo-text {
            flex: 1;
            padding-right: 50px;
        }

        .demo-video {
            flex: 1;
            position: relative;
        }

        .demo-video::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            opacity: 0.1;
            z-index: -1;
            border-radius: 20px;
        }

        .demo-video video {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Seção Comunidades */
        .communities {
            padding: 100px 0;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .communities h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        .community-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .community-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .community-item:hover {
            transform: translateY(-5px);
        }

        .community-item img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        /* Seção Customização */
        .customization {
            padding: 100px 0;
            text-align: center;
        }

        .customization h2 {
            margin-bottom: 50px;
        }

        .customization-options {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .customization-option {
            flex-basis: 30%;
            margin-bottom: 30px;
        }

        .customization-option img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        /* Seção conquistas
        .gamification {
            padding: 100px 0;
            background-color: rgba(255, 255, 255, 0.02);
            text-align: center;
        }

        .gamification h2 {
            margin-bottom: 50px;
        }

        .achievements {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .achievement {
            flex-basis: 22%;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .achievement-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* Seção Testimonials 
        .testimonials {
            padding: 100px 0;
        }

        .testimonials h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        .testimonial-carousel {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .testimonial-item {
            text-align: center;
            padding: 20px;
            display: none;
        }

        .testimonial-item.active {
            display: block;
        }

        .testimonial-item img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .testimonial-item p {
            font-style: italic;
            margin-bottom: 20px;
        }

        .testimonial-item .author {
            font-weight: 600;
        }
        */

        /* Seção planos */
        .plans {
            background-color: rgba(255, 255, 255, 0.02);
            padding: 100px 0;
            text-align: center;
        }

        .plans h2 {
            margin-bottom: 50px;
        }

        .plan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .plan-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .plan-item:hover {
            transform: scale(1.05);
        }

        .plan-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .plan-price {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .plan-features {
            list-style: none;
            margin-bottom: 30px;
        }

        /* Seção FAQ */
        .faq {
            padding: 100px 0;
        }

        .faq h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        .faq-item {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .faq-question {
            padding: 20px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-item.active .faq-answer {
            padding: 20px;
            max-height: 500px;
        }

        /* Seção Newsletter */
        .newsletter {
            padding: 100px 0;
            text-align: center;
        }

        .newsletter h2 {
            margin-bottom: 20px;
        }

        .newsletter p {
            margin-bottom: 30px;
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-form input[type="email"] {
            flex-grow: 1;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .newsletter-form button {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: none;
            padding: 10px 20px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter-form button:hover {
            background-color: var(--hover-color);
        }

        

    </style>

</head>


<body>
    <header>
        <nav class="container">
            <a href="index.php" class="logo-link"><div class="logo">NextPlay</div></a>
            <ul class="nav-links">
                <li><a href="#about">Sobre</a></li>
                <li><a href="#features">Funcionalidades</a></li>
                <li><a href="#plans">Planos</a></li>
                <li><a href="app/views/login.php">Login</a></li>
                <li><a href="app/views/register.php" class="btn">Experimente Agora</a></li>
            </ul>
        </nav>
    </header>

    
        <section id="about" class="hero container">
            <div class="hero-content">
                <h1>Revolucione sua vida social online</h1>
                <p>NextPlay é a rede social do futuro, onde inovação e diversão se encontram para criar experiências únicas de conexão.</p>
                <a href="app/views/register.php" class="btn">Cadastre-se gratuitamente</a>
            </div>
        </section>

    <main>
        <section id="features" class="features">
            <div class="container">
                <h2>Funcionalidades revolucionárias</h2>
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">💬</div>
                        <h3>Chat em tempo real</h3>
                        <p>Converse instantaneamente com amigos e grupos.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">👥</div>
                        <h3>Comunidades dinâmicas</h3>
                        <p>Crie e participe de grupos baseados em interesses.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🎉</div>
                        <h3>Eventos colaborativos</h3>
                        <p>Organize e participe de eventos online.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔗</div>
                        <h3>Integrações poderosas</h3>
                        <p>Conecte-se com suas plataformas favoritas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="demo">
            <div class="container demo-content">
                <div class="demo-text">
                    <h2>Experimente o NextPlay</h2>
                    <p>Veja como é fácil se conectar e interagir com os amigos na nossa plataforma.</p>
                </div>
                <div class="demo-video">
                    <video width="100%" controls>
                        <source src="https://websim.io/social-network/demo.mp4" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video>
                </div>
            </div>
        </section>

        <section class="communities">
            <div class="container">
                <h2>Comunidades em destaque</h2>
                <div class="community-grid">
                    <div class="community-item">
                        <img
                            src="https://page-images.websim.ai/Comunidade%20de%20Tecnologia_1024x1024xpBSbK19HLikDbtdsYx8d4fea4a59d33.jpg"
                            alt="Comunidade de Tecnologia">
                        <h3>Tech Enthusiasts</h3>
                        <p>Discuta as últimas novidades em tecnologia.</p>
                    </div>
                    <div class="community-item">
                        <img
                            src="https://page-images.websim.ai/Comunidade%20de%20Arte_1024x1024xpBSbK19HLikDbtdsYxf8dee701d0c9a.jpg"
                            alt="Comunidade de Arte">
                        <h3>Creative Corner</h3>
                        <p>Compartilhe e aprecie arte em todas as formas.</p>
                    </div>
                    <div class="community-item">
                        <img
                            src="https://page-images.websim.ai/Comunidade%20de%20Fitness_1024x1024xpBSbK19HLikDbtdsYx97cec21b8a894.jpg"
                            alt="Comunidade de Fitness">
                        <h3>Fitness Junkies</h3>
                        <p>Motivação e dicas para um estilo de vida saudável.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="customization">
            <div class="container">
                <h2>Personalize sua experiência</h2>
                <div class="customization-options">
                    <div class="customization-option">
                        <img src="https://page-images.websim.ai/Personaliza%C3%A7%C3%A3o%20de%20perfil_1024x1024xpBSbK19HLikDbtdsYx90640b6bc60e.jpg" alt="Personalização de perfil">
                        <h3>Perfil único</h3>
                        <p>Crie um perfil que reflita sua personalidade.</p>
                    </div>
                    <div class="customization-option">
                        <img src="https://page-images.websim.ai/Temas%20personalizados_1024x1024xpBSbK19HLikDbtdsYxc07083ff6d1e1.jpg" alt="Temas personalizados">
                        <h3>Temas vibrantes</h3>
                        <p>Escolha entre diversos temas ou crie o seu próprio.</p>
                    </div>
                    <div class="customization-option">
                        <img src="https://page-images.websim.ai/Notifica%C3%A7%C3%B5es%20personalizadas_1024x1024xpBSbK19HLikDbtdsYx243b6c550b1e6.jpg" alt="Notificações personalizadas">
                        <h3>Notificações inteligentes</h3>
                        <p>Controle o que você vê e quando vê.</p>
                    </div>
                </div>
            </div>
        </section>

        <!--
        <section class="gamification">
            <div class="container">
                <h2>Conquiste e evolua</h2>
                <div class="achievements">
                    <div class="achievement">
                        <div class="achievement-icon">🏆</div>
                        <h3>Super Conectado</h3>
                        <p>Faça 100 novos amigos</p>
                    </div>
                    <div class="achievement">
                        <div class="achievement-icon">📝</div>
                        <h3>Escritor Ativo</h3>
                        <p>Publique 50 posts</p>
                    </div>
                    <div class="achievement">
                        <div class="achievement-icon">🎨</div>
                        <h3>Artista Digital</h3>
                        <p>Compartilhe 30 criações originais</p>
                    </div>
                    <div class="achievement">
                        <div class="achievement-icon">🌟</div>
                        <h3>Influenciador</h3>
                        <p>Alcance 1000 seguidores</p>
                    </div>
                </div>
            </div>
        </section>
        -->

        <section id="plans" class="plans">
            <div class="container">
                <h2>Escolha seu plano</h2>
                <div class="plan-grid">
                    <div class="plan-item">
                        <div class="plan-name">Básico</div>
                        <div class="plan-price">Grátis</div>
                        <ul class="plan-features">
                            <li>Acesso a comunidades</li>
                            <li>Chat em tempo real</li>
                            <li>Perfil personalizável</li>
                        </ul>
                        <a href="#signup" class="btn">Comece Agora</a>
                    </div>
                    <div class="plan-item">
                        <div class="plan-name">Pro</div>
                        <div class="plan-price">R$9.99/mês</div>
                        <ul class="plan-features">
                            <li>Todos os recursos do plano Básico</li>
                            <li>Sem anúncios</li>
                            <li>Badges exclusivos</li>
                            <li>Suporte prioritário</li>
                        </ul>
                        <a href="#signup-pro" class="btn">Experimente</a>
                    </div>
                    <div class="plan-item">
                        <div class="plan-name">Ultimate</div>
                        <div class="plan-price">R$19.99/mês</div>
                        <ul class="plan-features">
                            <li>Todos os recursos do plano Pro</li>
                            <!-- <li>Hospedagem de eventos VIP</li> -->
                            <li>Análises avançadas</li>
                            <li>Acesso antecipado a novos recursos</li>
                        </ul>
                        <a href="#signup-ultimate" class="btn">Experimente</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq">
            <div class="container">
                <h2>Perguntas Frequentes</h2>
                <div class="faq-item">
                    <div class="faq-question">Como posso criar uma conta no NextPlay? <span class="toggle">+</span></div>
                    <div class="faq-answer">Criar uma conta no NextPlay é prático e fácil! Basta clicar no botão "Experimente Agora"
                        no topo da página e seguir as instruções. Você pode se cadastrar usando seu e-mail e criando um nome de usuário.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">O NextPlay é seguro e privado? <span class="toggle">+</span></div>
                    <div class="faq-answer">Sim, a segurança e privacidade dos nossos usuários são nossas principais prioridades.
                        Utilizamos criptografia para todas as comunicações e oferecemos controles de privacidade
                        para que você possa gerenciar quem vê suas informações.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Posso instalar o NextPlay em meu celular? <span class="toggle">+</span></div>
                    <div class="faq-answer">Ainda não. Atualmente, o NextPlay está disponível apenas como uma versão web. Mas
                        em breve, pretendemos disponibilizar o NextPlay como um aplicativo tanto para iOS quanto para Android.</div>
                </div>
            </div>
        </section>

        <section class="newsletter">
            <div class="container">
                <h2>Fique por dentro das novidades</h2>
                <p>Inscreva-se no nosso boletim informativo para receber atualizações, dicas e ofertas exclusivas.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu e-mail" required>
                    <button type="submit">Inscrever-se</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Script que permite o funcionamento da seção FAQ-->
    <script>
    document.querySelectorAll('.faq-question').forEach((question) => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            faqItem.classList.toggle('active');
        });
    });
    </script>

    <?php include 'app/views/footer.php'; ?>
</body>