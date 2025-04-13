<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* Reclamation/show.html.twig */
class __TwigTemplate_6f4458cc4a970ece8d7c7140e949a3aa extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "Reclamation/show.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "Reclamation/show.html.twig"));

        // line 1
        yield "

<!DOCTYPE html>
<html lang=\"en\">
    
<head>
    <title>Event - Landing Page</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>  
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"description\" content=\"\">

    <!--== CSS Files ==-->
    <link href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/bootstrap.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/font-awesome.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/owl.carousel.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/flexslider.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/fancySelect.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/responsive.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">

    <!--== Google Fonts ==-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<body>
    <header id=\"header\">
        <div id=\"menu\" class=\"header-menu fixed\">
            <div class=\"box\">
                <div class=\"row\">
                    <nav role=\"navigation\" class=\"col-sm-12\">
                        <div class=\"navbar-header\">
                            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                                <span class=\"sr-only\">Toggle navigation</span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                            </button>

                            <!--== Logo ==-->
                            <span class=\"navbar-brand logo\">
                                Evento
                            </span>
                        </div>
                        <div class=\"navbar-collapse collapse\">
                            <!--== Navigation Menu ==-->
                            <ul class=\"nav navbar-nav\">
                                <li class=\"current\"><a href=\"#header\">Home</a></li>
                                <li><a href=\"#schedule\">Reclamation</a></li>
                                <li><a href=\"#testimonial\">Testimonials</a></li>
                                <li><a href=\"#contact\">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!--== Site Description ==-->
        <div class=\"header-cta\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"entry-content\">
                        <p><span class=\"start-text\"><b>From THE MARCH 7, 2014</b></span></p>
                        <h4 class=\"entry-title\"><a href=\"#\">Organizing World class events</a></h4>
                        <h5><span><b>Schrodinger confirms that Germany international ...</b></span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"header-bg\">
            <div id=\"preloader\">
                <div class=\"preloader\"></div>
            </div>
            <div class=\"main-slider\" id=\"main-slider\">
                <!--== Main Slider ==-->
                <ul class=\"slides\">
                    <li><img src=\"";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/demo/bg-slide-01.jpg"), "html", null, true);
        yield "\" alt=\"Slide Image\"/></li>
                    <li><img src=\"";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/demo/bg-slide-02.jpg"), "html", null, true);
        yield "\" alt=\"Slide Image 2\"/></li>
                </ul>
            </div>
        </div>
    </header>

            <!--==========-->
            <!--==========-->
    <h1>Reclamation</h1>

    <h1>";
        // line 91
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 91, $this->source); })()), "subject", [], "any", false, false, false, 91), "html", null, true);
        yield "</h1>
    <p><strong>Evenement Title:</strong> ";
        // line 92
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 92, $this->source); })()), "evenement", [], "any", false, false, false, 92), "nom", [], "any", false, false, false, 92), "html", null, true);
        yield "</p> <!-- Corrected -->
    <p><strong>Email:</strong> ";
        // line 93
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 93, $this->source); })()), "email", [], "any", false, false, false, 93), "html", null, true);
        yield "</p>
    <p><strong>Date:</strong> ";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 94, $this->source); })()), "dateReclamation", [], "any", false, false, false, 94), "Y-m-d H:i"), "html", null, true);
        yield "</p>

    <form method=\"post\" action=\"";
        // line 96
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("reclamation_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 96, $this->source); })()), "id", [], "any", false, false, false, 96)]), "html", null, true);
        yield "\" onsubmit=\"return confirm('Are you sure?');\">
        <input type=\"hidden\" name=\"_token\" value=\"";
        // line 97
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete" . CoreExtension::getAttribute($this->env, $this->source, (isset($context["reclamation"]) || array_key_exists("reclamation", $context) ? $context["reclamation"] : (function () { throw new RuntimeError('Variable "reclamation" does not exist.', 97, $this->source); })()), "id", [], "any", false, false, false, 97))), "html", null, true);
        yield "\">
        <button class=\"btn btn-danger\">Delete</button>
    </form>

    <a href=\"";
        // line 101
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("reclamation_index");
        yield "\">Back</a>




            <!--==========-->
            <!--==========-->
            <!--===============================-->
            <!--== Testimonial =============-->
            <!--===============================-->
    <section id=\"testimonial\" class=\"testimonial-area\">
        <div class=\"container\">
            <div class=\"title-start col-md-4 col-md-offset-4\">
                <h2 class=\"team-heading white\">Testimonial</h2>
                <p class=\"sub-text text-center\">What they say and see among us</p>
            </div>
            <div class=\"row\">
                <div class=\"col-xs-12\"></div>
                <div id=\"testimonial-container\" class=\"col-xs-12\">
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 121
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Monir Hossain</strong>
                        <br>
                        <small>C.E.O</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial2.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Nur Ul Hossain</strong>
                        <br>
                        <small>Project Manager</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 135
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial3.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Rub Elvi</strong>
                        <br>
                        <small>Developer</small>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </section><!-- testimonial -->
            
            <div class=\"content mcontent\">
                <div id=\"gotop\" class=\"gotop fa fa-arrow-up\"></div>
            </div>
        </div>
         <!-- Contact Area -->

        <section id=\"contact\" class=\"mapWrap\">
            <div id=\"googleMap\" style=\"width:100%;\"></div>
            <div id=\"contact-area\">
                <div class=\"container\">
                    <h2 class=\"block_title\">Hey !!!</h2>
                    <div class=\"row\">
                        <div class=\"col-xs-12\"></div>
                        <div class=\"col-sm-6\">
                            <div class=\"moreDetails\">
                                <h2 class=\"con-title\">More About me</h2>
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum animi repudiandae nihil aspernatur repellat temporibus doloremque sint ea laboriosam, excepturi iure inventore rerum voluptatibus, suscipit totam, sit necessitatibus. Rerum, blanditiis. </p>
                                <ul class=\"address\">
                                    <li><i class=\"pe-7s-map-marker\"></i><span>1600 Pennsylvania Ave NW,<br>Washington, DC 20500,<br>United States</span></li>
                                    <li><i class=\"pe-7s-mail\"></i><span>example@gmail.com</span></li>
                                    <li><i class=\"pe-7s-phone\"></i><span>+1-202-555-0144</span></li>
                                    <li><i class=\"pe-7s-global\"></i><span><a href=\"#\">www.themewagon.com</a></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class=\"col-sm-6\">
                            <h2 class=\"con-title\">Contact us</h2>
                            <form role=\"form\">
                              <div class=\"form-group\">
                                <input type=\"text\" class=\"form-control\" id=\"user_name\" placeholder=\"Enter your name\">
                              </div>
                              <div class=\"form-group\">
                                <input type=\"email\" class=\"form-control\" id=\"your_email\" placeholder=\"Enter your email\">
                              </div>
                              <div class=\"form-group\">
                                <textarea name=\"InputMessage\" id=\"user_message\" class=\"form-control\" rows=\"5\" required></textarea>
                              </div>

                              <button type=\"submit\" class=\"btn medium\">Let us know</button>
                            </form>   
                        </div>
                    </div>
                </div><!-- container -->
            </div><!-- contact-area -->
            <div id=\"social\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-xs-12\">
                            <ul class=\"scoialinks\">
                                <li class=\"normal-txt\">Find us on</li>
                                <li class=\"social-icons\"><a class=\"facebook\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"twitter\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"linkedin\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"google-plus\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"wordpress\" href=\"#\"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- social -->
        </section><!-- contact -->
    <footer>
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-sm-6\">
                    <p class=\"copyright\">© Copyright 2014 <a href=\"http://wwww.technextit.com\" target=\"_blank\">Technext</a></p>
                </div>
                <div class=\"col-sm-6\">
                    <p class=\"designed\">Designed and Developed by <a href=\"http://themewagon.com\" target=\"_blank\">Themewagon</a></p>
                </div>
            </div>
        </div>
    </footer>


    <!--== Javascript Files ==-->
    <script src=\"https://maps.googleapis.com/maps/api/js?sensor=false\"></script>
    <script src=\"";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery-2.1.0.min.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 224
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/bootstrap.min.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 225
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.scrollTo.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 226
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.nav.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 227
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.flexslider.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 228
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.accordion.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 229
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.placeholder.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 230
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.fitvids.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 231
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/gmap3.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 232
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/fancySelect.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 233
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/owl.carousel.min.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 234
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/main.js"), "html", null, true);
        yield "\"></script>
    <script type=\"text/javascript\"> 
    \$(document).ready(function() {
        \$(\"#testimonial-container\").owlCarousel({
            navigation : false, // Show next and prev buttons
            slideSpeed : 700,
            paginationSpeed : 400,
            singleItem:true,
        });
    });
    </script>
</body>
</html>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "Reclamation/show.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  373 => 234,  369 => 233,  365 => 232,  361 => 231,  357 => 230,  353 => 229,  349 => 228,  345 => 227,  341 => 226,  337 => 225,  333 => 224,  329 => 223,  238 => 135,  228 => 128,  218 => 121,  195 => 101,  188 => 97,  184 => 96,  179 => 94,  175 => 93,  171 => 92,  167 => 91,  154 => 81,  150 => 80,  86 => 19,  82 => 18,  78 => 17,  74 => 16,  70 => 15,  66 => 14,  62 => 13,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("

<!DOCTYPE html>
<html lang=\"en\">
    
<head>
    <title>Event - Landing Page</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>  
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"description\" content=\"\">

    <!--== CSS Files ==-->
    <link href=\"{{ asset('css/bootstrap.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/style.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/font-awesome.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/owl.carousel.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/flexslider.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/fancySelect.css') }}\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"{{ asset('css/responsive.css') }}\" rel=\"stylesheet\" media=\"screen\">

    <!--== Google Fonts ==-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<body>
    <header id=\"header\">
        <div id=\"menu\" class=\"header-menu fixed\">
            <div class=\"box\">
                <div class=\"row\">
                    <nav role=\"navigation\" class=\"col-sm-12\">
                        <div class=\"navbar-header\">
                            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                                <span class=\"sr-only\">Toggle navigation</span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                            </button>

                            <!--== Logo ==-->
                            <span class=\"navbar-brand logo\">
                                Evento
                            </span>
                        </div>
                        <div class=\"navbar-collapse collapse\">
                            <!--== Navigation Menu ==-->
                            <ul class=\"nav navbar-nav\">
                                <li class=\"current\"><a href=\"#header\">Home</a></li>
                                <li><a href=\"#schedule\">Reclamation</a></li>
                                <li><a href=\"#testimonial\">Testimonials</a></li>
                                <li><a href=\"#contact\">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!--== Site Description ==-->
        <div class=\"header-cta\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"entry-content\">
                        <p><span class=\"start-text\"><b>From THE MARCH 7, 2014</b></span></p>
                        <h4 class=\"entry-title\"><a href=\"#\">Organizing World class events</a></h4>
                        <h5><span><b>Schrodinger confirms that Germany international ...</b></span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"header-bg\">
            <div id=\"preloader\">
                <div class=\"preloader\"></div>
            </div>
            <div class=\"main-slider\" id=\"main-slider\">
                <!--== Main Slider ==-->
                <ul class=\"slides\">
                    <li><img src=\"{{ asset('images/demo/bg-slide-01.jpg') }}\" alt=\"Slide Image\"/></li>
                    <li><img src=\"{{ asset('images/demo/bg-slide-02.jpg') }}\" alt=\"Slide Image 2\"/></li>
                </ul>
            </div>
        </div>
    </header>

            <!--==========-->
            <!--==========-->
    <h1>Reclamation</h1>

    <h1>{{ reclamation.subject }}</h1>
    <p><strong>Evenement Title:</strong> {{ reclamation.evenement.nom }}</p> <!-- Corrected -->
    <p><strong>Email:</strong> {{ reclamation.email }}</p>
    <p><strong>Date:</strong> {{ reclamation.dateReclamation|date('Y-m-d H:i') }}</p>

    <form method=\"post\" action=\"{{ path('reclamation_delete', {'id': reclamation.id}) }}\" onsubmit=\"return confirm('Are you sure?');\">
        <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete' ~ reclamation.id) }}\">
        <button class=\"btn btn-danger\">Delete</button>
    </form>

    <a href=\"{{ path('reclamation_index') }}\">Back</a>




            <!--==========-->
            <!--==========-->
            <!--===============================-->
            <!--== Testimonial =============-->
            <!--===============================-->
    <section id=\"testimonial\" class=\"testimonial-area\">
        <div class=\"container\">
            <div class=\"title-start col-md-4 col-md-offset-4\">
                <h2 class=\"team-heading white\">Testimonial</h2>
                <p class=\"sub-text text-center\">What they say and see among us</p>
            </div>
            <div class=\"row\">
                <div class=\"col-xs-12\"></div>
                <div id=\"testimonial-container\" class=\"col-xs-12\">
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Monir Hossain</strong>
                        <br>
                        <small>C.E.O</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial2.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Nur Ul Hossain</strong>
                        <br>
                        <small>Project Manager</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial3.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis. Corrupti totam amet aperiam aut voluptate nobis dolor at soluta.</p>
                        <strong>Rub Elvi</strong>
                        <br>
                        <small>Developer</small>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </section><!-- testimonial -->
            
            <div class=\"content mcontent\">
                <div id=\"gotop\" class=\"gotop fa fa-arrow-up\"></div>
            </div>
        </div>
         <!-- Contact Area -->

        <section id=\"contact\" class=\"mapWrap\">
            <div id=\"googleMap\" style=\"width:100%;\"></div>
            <div id=\"contact-area\">
                <div class=\"container\">
                    <h2 class=\"block_title\">Hey !!!</h2>
                    <div class=\"row\">
                        <div class=\"col-xs-12\"></div>
                        <div class=\"col-sm-6\">
                            <div class=\"moreDetails\">
                                <h2 class=\"con-title\">More About me</h2>
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum animi repudiandae nihil aspernatur repellat temporibus doloremque sint ea laboriosam, excepturi iure inventore rerum voluptatibus, suscipit totam, sit necessitatibus. Rerum, blanditiis. </p>
                                <ul class=\"address\">
                                    <li><i class=\"pe-7s-map-marker\"></i><span>1600 Pennsylvania Ave NW,<br>Washington, DC 20500,<br>United States</span></li>
                                    <li><i class=\"pe-7s-mail\"></i><span>example@gmail.com</span></li>
                                    <li><i class=\"pe-7s-phone\"></i><span>+1-202-555-0144</span></li>
                                    <li><i class=\"pe-7s-global\"></i><span><a href=\"#\">www.themewagon.com</a></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class=\"col-sm-6\">
                            <h2 class=\"con-title\">Contact us</h2>
                            <form role=\"form\">
                              <div class=\"form-group\">
                                <input type=\"text\" class=\"form-control\" id=\"user_name\" placeholder=\"Enter your name\">
                              </div>
                              <div class=\"form-group\">
                                <input type=\"email\" class=\"form-control\" id=\"your_email\" placeholder=\"Enter your email\">
                              </div>
                              <div class=\"form-group\">
                                <textarea name=\"InputMessage\" id=\"user_message\" class=\"form-control\" rows=\"5\" required></textarea>
                              </div>

                              <button type=\"submit\" class=\"btn medium\">Let us know</button>
                            </form>   
                        </div>
                    </div>
                </div><!-- container -->
            </div><!-- contact-area -->
            <div id=\"social\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-xs-12\">
                            <ul class=\"scoialinks\">
                                <li class=\"normal-txt\">Find us on</li>
                                <li class=\"social-icons\"><a class=\"facebook\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"twitter\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"linkedin\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"google-plus\" href=\"#\"></a></li>
                                <li class=\"social-icons\"><a class=\"wordpress\" href=\"#\"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- social -->
        </section><!-- contact -->
    <footer>
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-sm-6\">
                    <p class=\"copyright\">© Copyright 2014 <a href=\"http://wwww.technextit.com\" target=\"_blank\">Technext</a></p>
                </div>
                <div class=\"col-sm-6\">
                    <p class=\"designed\">Designed and Developed by <a href=\"http://themewagon.com\" target=\"_blank\">Themewagon</a></p>
                </div>
            </div>
        </div>
    </footer>


    <!--== Javascript Files ==-->
    <script src=\"https://maps.googleapis.com/maps/api/js?sensor=false\"></script>
    <script src=\"{{ asset('js/jquery-2.1.0.min.js') }}\"></script>
    <script src=\"{{ asset('js/bootstrap.min.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.scrollTo.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.nav.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.flexslider.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.accordion.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.placeholder.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.fitvids.js') }}\"></script>
    <script src=\"{{ asset('js/gmap3.js') }}\"></script>
    <script src=\"{{ asset('js/fancySelect.js') }}\"></script>
    <script src=\"{{ asset('js/owl.carousel.min.js') }}\"></script>
    <script src=\"{{ asset('js/main.js') }}\"></script>
    <script type=\"text/javascript\"> 
    \$(document).ready(function() {
        \$(\"#testimonial-container\").owlCarousel({
            navigation : false, // Show next and prev buttons
            slideSpeed : 700,
            paginationSpeed : 400,
            singleItem:true,
        });
    });
    </script>
</body>
</html>", "Reclamation/show.html.twig", "C:\\Users\\Med\\Desktop\\Project_Symphony\\templates\\Reclamation\\show.html.twig");
    }
}
