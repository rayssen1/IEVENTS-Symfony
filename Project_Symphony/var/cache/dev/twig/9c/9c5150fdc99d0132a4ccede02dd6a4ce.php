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

/* reclamation/new.html.twig */
class __TwigTemplate_0e344e4b46430c1ad7c26503211ad23c extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "reclamation/new.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "reclamation/new.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <title>Event - Landing Page</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>  
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"description\" content=\"\">

    

    <!--== CSS Files ==-->
    <link href=\"";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/bootstrap.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/font-awesome.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/owl.carousel.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/flexslider.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/fancySelect.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/responsive.css"), "html", null, true);
        yield "\" rel=\"stylesheet\" media=\"screen\">

    <!--== Google Fonts ==-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!--== SweetAlert2 ==-->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>

    <style>
    /* Style pour le formulaire */
#reclamation-form {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

#reclamation-form .form-row {
    margin-bottom: 15px;
}

#reclamation-form .form-label {
    font-weight: bold;
    margin-bottom: 5px;
}

#reclamation-form .form-control {
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

#reclamation-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

#reclamation-form .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

#reclamation-form .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 12px;
}
</style>
    
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
                            <span class=\"navbar-brand logo\">I-Events</span>
                        </div>
                        <div class=\"navbar-collapse collapse\">
                            <!--== Navigation Menu ==-->
                            <ul class=\"nav navbar-nav\">
                                <li class=\"current\"><a href=\"#header\">Home</a></li>
                                <li><a href=\"#reclamation\">Reclamation</a></li>
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
        // line 136
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/demo/bg-slide-01.jpg"), "html", null, true);
        yield "\" alt=\"Slide Image\"/></li>
                    <li><img src=\"";
        // line 137
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/demo/bg-slide-02.jpg"), "html", null, true);
        yield "\" alt=\"Slide Image 2\"/></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

<!-- Reclamation Form -->
<section id=\"reclamation\">
    <div class=\"container\">
        <h2 class=\"team-heading text-center mb-4\">Reclamation Form</h2>
        
        ";
        // line 154
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 154, $this->source); })()), 'form_start', ["attr" => ["id" => "reclamation-form"]]);
        yield "
            <div class=\"form-row\">
                ";
        // line 156
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 156, $this->source); })()), "email", [], "any", false, false, false, 156), 'label', ["label_attr" => ["class" => "form-label"], "label" => "Email Address"]);
        yield "
                ";
        // line 157
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 157, $this->source); })()), "email", [], "any", false, false, false, 157), 'widget', ["attr" => ["class" => "form-control"]]);
        yield "
                <div class=\"invalid-feedback\">
                    ";
        // line 159
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 159, $this->source); })()), "email", [], "any", false, false, false, 159), 'errors');
        yield "
                </div>
            </div>

            <div class=\"form-row\">
                ";
        // line 164
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 164, $this->source); })()), "evenement", [], "any", false, false, false, 164), 'label', ["label_attr" => ["class" => "form-label"], "label" => "Event"]);
        yield "
                ";
        // line 165
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 165, $this->source); })()), "evenement", [], "any", false, false, false, 165), 'widget', ["attr" => ["class" => "form-control"]]);
        yield "
                <div class=\"invalid-feedback\">
                    ";
        // line 167
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 167, $this->source); })()), "evenement", [], "any", false, false, false, 167), 'errors');
        yield "
                </div>
            </div>

            <div class=\"form-row\">
                ";
        // line 172
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 172, $this->source); })()), "dateReclamation", [], "any", false, false, false, 172), 'label', ["label_attr" => ["class" => "form-label"], "label" => "Reclamation Date"]);
        yield "
                ";
        // line 173
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 173, $this->source); })()), "dateReclamation", [], "any", false, false, false, 173), 'widget', ["attr" => ["class" => "form-control"]]);
        yield "
                <div class=\"invalid-feedback\">
                    ";
        // line 175
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 175, $this->source); })()), "dateReclamation", [], "any", false, false, false, 175), 'errors');
        yield "
                </div>
            </div>

<div class=\"form-row\">
    ";
        // line 180
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 180, $this->source); })()), "subject", [], "any", false, false, false, 180), 'label', ["label_attr" => ["class" => "form-label"], "label" => "Subject"]);
        yield "
    ";
        // line 181
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 181, $this->source); })()), "subject", [], "any", false, false, false, 181), 'widget', ["attr" => ["class" => "form-control", "rows" => 4]]);
        yield "
    <div class=\"invalid-feedback\">
        ";
        // line 183
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 183, $this->source); })()), "subject", [], "any", false, false, false, 183), 'errors');
        yield "
    </div>
</div>

            <div class=\"form-row\">
                ";
        // line 188
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 188, $this->source); })()), "rate", [], "any", false, false, false, 188), 'label', ["label_attr" => ["class" => "form-label"], "label" => "Rate"]);
        yield "
                ";
        // line 189
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 189, $this->source); })()), "rate", [], "any", false, false, false, 189), 'widget', ["attr" => ["class" => "form-control"]]);
        yield "
                <div class=\"invalid-feedback\">
                    ";
        // line 191
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 191, $this->source); })()), "rate", [], "any", false, false, false, 191), 'errors');
        yield "
                </div>
            </div>

            <div class=\"text-center\">
                <button type=\"button\" class=\"btn btn-success btn-lg\" id=\"confirm-button\">Submit</button>
            </div>
        ";
        // line 198
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 198, $this->source); })()), 'form_end');
        yield "
    </div>
</section>


    <br>
    <br>

    <!--== Testimonials =============-->
    <section id=\"testimonial\" class=\"testimonial-area\">
        <div class=\"container\">
            <div class=\"title-start col-md-4 col-md-offset-4\">
                <h2 class=\"team-heading white\">Testimonial</h2>
                <p class=\"sub-text text-center\">What they say and see among us</p>
            </div>
            <div class=\"row\">
                <div id=\"testimonial-container\" class=\"col-xs-12\">
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 216
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Monir Hossain</strong>
                        <br>
                        <small>C.E.O</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial2.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Nur Ul Hossain</strong>
                        <br>
                        <small>Project Manager</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"";
        // line 230
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/testimonial3.jpg"), "html", null, true);
        yield "\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Rub Elvi</strong>
                        <br>
                        <small>Developer</small>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </section><!-- testimonial -->

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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum animi repudiandae nihil aspernatur repellat temporibus doloremque sint ea laboriosam.</p>
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
    <script src=\"";
        // line 311
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery-2.1.0.min.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 312
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/bootstrap.min.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 313
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.scrollTo.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 314
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/waypoints.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 315
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/owl.carousel.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 316
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery.flexslider.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 317
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/fancySelect.js"), "html", null, true);
        yield "\"></script>
    <script src=\"";
        // line 318
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/functions.js"), "html", null, true);
        yield "\"></script>

<script>
    document.getElementById('confirm-button').addEventListener('click', async (event) => {
        event.preventDefault();  // Prevent form submission until after the notification

        const email = document.querySelector('#reclamation_email').value;
        const subject = document.querySelector('#reclamation_subject').value;
        const rate = document.querySelector('#reclamation_rate').value;

        let formValid = true;  // Flag to track form validity

        // Vérification du format de l'email
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}\$/;
        if (!email) {
            Swal.fire({ icon: 'warning', title: 'Please enter an email.' });
            formValid = false;
        } else if (!emailRegex.test(email)) {
            Swal.fire({ icon: 'warning', title: 'Invalid email format.' });
            formValid = false;
        }

        // Vérification de la longueur du subject (maximum 50 caractères)
        if (!subject) {
            Swal.fire({ icon: 'warning', title: 'Subject cannot be empty.' });
            formValid = false;
        } else if (subject.length > 100) {
            Swal.fire({ icon: 'warning', title: 'Subject should not exceed 100 characters.' });
            formValid = false;
        }

        // Vérification de la valeur du rate (not empty, and within range 1-5)
        if (!rate) {
            Swal.fire({ icon: 'warning', title: 'Rate cannot be empty.' });
            formValid = false;
        } else if (rate < 1 || rate > 5) {
            Swal.fire({ icon: 'warning', title: 'Rate should be between 1 and 5.' });
            formValid = false;
        }

        // If all checks pass, proceed to submit the form
        if (formValid) {
            try {
                const response = await fetch('/reclamation/check-email?email=' + encodeURIComponent(email));
                const data = await response.json();

                if (data.exists) {
                    const confirmUpdate = confirm(\"A Reclamation with this email already exists. Do you really want to update it?\");
                    if (!confirmUpdate) return;  // Do not submit if the user cancels
                }

                // Show success notification after validation
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Form submitted successfully!', 
                    text: 'Your reclamation has been submitted.' 
                });

                // Now submit the form after all validation passes
                document.querySelector('#reclamation-form').submit();

            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error checking email.' });
                console.error(e);
            }
        }
    });
</script>


    

</body>
</html>


























";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "reclamation/new.html.twig";
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
        return array (  475 => 318,  471 => 317,  467 => 316,  463 => 315,  459 => 314,  455 => 313,  451 => 312,  447 => 311,  363 => 230,  353 => 223,  343 => 216,  322 => 198,  312 => 191,  307 => 189,  303 => 188,  295 => 183,  290 => 181,  286 => 180,  278 => 175,  273 => 173,  269 => 172,  261 => 167,  256 => 165,  252 => 164,  244 => 159,  239 => 157,  235 => 156,  230 => 154,  210 => 137,  206 => 136,  85 => 18,  81 => 17,  77 => 16,  73 => 15,  69 => 14,  65 => 13,  61 => 12,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!--== SweetAlert2 ==-->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>

    <style>
    /* Style pour le formulaire */
#reclamation-form {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

#reclamation-form .form-row {
    margin-bottom: 15px;
}

#reclamation-form .form-label {
    font-weight: bold;
    margin-bottom: 5px;
}

#reclamation-form .form-control {
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

#reclamation-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

#reclamation-form .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

#reclamation-form .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 12px;
}
</style>
    
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
                            <span class=\"navbar-brand logo\">I-Events</span>
                        </div>
                        <div class=\"navbar-collapse collapse\">
                            <!--== Navigation Menu ==-->
                            <ul class=\"nav navbar-nav\">
                                <li class=\"current\"><a href=\"#header\">Home</a></li>
                                <li><a href=\"#reclamation\">Reclamation</a></li>
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

<!-- Reclamation Form -->
<section id=\"reclamation\">
    <div class=\"container\">
        <h2 class=\"team-heading text-center mb-4\">Reclamation Form</h2>
        
        {{ form_start(form, {'attr': {'id': 'reclamation-form'}}) }}
            <div class=\"form-row\">
                {{ form_label(form.email, 'Email Address', {'label_attr': {'class': 'form-label'}}) }}
                {{ form_widget(form.email, {'attr': {'class': 'form-control'}}) }}
                <div class=\"invalid-feedback\">
                    {{ form_errors(form.email) }}
                </div>
            </div>

            <div class=\"form-row\">
                {{ form_label(form.evenement, 'Event', {'label_attr': {'class': 'form-label'}}) }}
                {{ form_widget(form.evenement, {'attr': {'class': 'form-control'}}) }}
                <div class=\"invalid-feedback\">
                    {{ form_errors(form.evenement) }}
                </div>
            </div>

            <div class=\"form-row\">
                {{ form_label(form.dateReclamation, 'Reclamation Date', {'label_attr': {'class': 'form-label'}}) }}
                {{ form_widget(form.dateReclamation, {'attr': {'class': 'form-control'}}) }}
                <div class=\"invalid-feedback\">
                    {{ form_errors(form.dateReclamation) }}
                </div>
            </div>

<div class=\"form-row\">
    {{ form_label(form.subject, 'Subject', {'label_attr': {'class': 'form-label'}}) }}
    {{ form_widget(form.subject, {'attr': {'class': 'form-control', 'rows': 4}}) }}
    <div class=\"invalid-feedback\">
        {{ form_errors(form.subject) }}
    </div>
</div>

            <div class=\"form-row\">
                {{ form_label(form.rate, 'Rate', {'label_attr': {'class': 'form-label'}}) }}
                {{ form_widget(form.rate, {'attr': {'class': 'form-control'}}) }}
                <div class=\"invalid-feedback\">
                    {{ form_errors(form.rate) }}
                </div>
            </div>

            <div class=\"text-center\">
                <button type=\"button\" class=\"btn btn-success btn-lg\" id=\"confirm-button\">Submit</button>
            </div>
        {{ form_end(form) }}
    </div>
</section>


    <br>
    <br>

    <!--== Testimonials =============-->
    <section id=\"testimonial\" class=\"testimonial-area\">
        <div class=\"container\">
            <div class=\"title-start col-md-4 col-md-offset-4\">
                <h2 class=\"team-heading white\">Testimonial</h2>
                <p class=\"sub-text text-center\">What they say and see among us</p>
            </div>
            <div class=\"row\">
                <div id=\"testimonial-container\" class=\"col-xs-12\">
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Monir Hossain</strong>
                        <br>
                        <small>C.E.O</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial2.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Nur Ul Hossain</strong>
                        <br>
                        <small>Project Manager</small>
                    </div>
                    <div class=\"testimonila-block\">
                        <img src=\"{{ asset('images/testimonial3.jpg') }}\" alt=\"clients\" class=\"selfshot\">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem sed mollitia illum! Molestiae dignissimos, hic dolorem et eius ut nobis.</p>
                        <strong>Rub Elvi</strong>
                        <br>
                        <small>Developer</small>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </section><!-- testimonial -->

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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum animi repudiandae nihil aspernatur repellat temporibus doloremque sint ea laboriosam.</p>
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
    <script src=\"{{ asset('js/jquery-2.1.0.min.js') }}\"></script>
    <script src=\"{{ asset('js/bootstrap.min.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.scrollTo.js') }}\"></script>
    <script src=\"{{ asset('js/waypoints.js') }}\"></script>
    <script src=\"{{ asset('js/owl.carousel.js') }}\"></script>
    <script src=\"{{ asset('js/jquery.flexslider.js') }}\"></script>
    <script src=\"{{ asset('js/fancySelect.js') }}\"></script>
    <script src=\"{{ asset('js/functions.js') }}\"></script>

<script>
    document.getElementById('confirm-button').addEventListener('click', async (event) => {
        event.preventDefault();  // Prevent form submission until after the notification

        const email = document.querySelector('#reclamation_email').value;
        const subject = document.querySelector('#reclamation_subject').value;
        const rate = document.querySelector('#reclamation_rate').value;

        let formValid = true;  // Flag to track form validity

        // Vérification du format de l'email
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}\$/;
        if (!email) {
            Swal.fire({ icon: 'warning', title: 'Please enter an email.' });
            formValid = false;
        } else if (!emailRegex.test(email)) {
            Swal.fire({ icon: 'warning', title: 'Invalid email format.' });
            formValid = false;
        }

        // Vérification de la longueur du subject (maximum 50 caractères)
        if (!subject) {
            Swal.fire({ icon: 'warning', title: 'Subject cannot be empty.' });
            formValid = false;
        } else if (subject.length > 100) {
            Swal.fire({ icon: 'warning', title: 'Subject should not exceed 100 characters.' });
            formValid = false;
        }

        // Vérification de la valeur du rate (not empty, and within range 1-5)
        if (!rate) {
            Swal.fire({ icon: 'warning', title: 'Rate cannot be empty.' });
            formValid = false;
        } else if (rate < 1 || rate > 5) {
            Swal.fire({ icon: 'warning', title: 'Rate should be between 1 and 5.' });
            formValid = false;
        }

        // If all checks pass, proceed to submit the form
        if (formValid) {
            try {
                const response = await fetch('/reclamation/check-email?email=' + encodeURIComponent(email));
                const data = await response.json();

                if (data.exists) {
                    const confirmUpdate = confirm(\"A Reclamation with this email already exists. Do you really want to update it?\");
                    if (!confirmUpdate) return;  // Do not submit if the user cancels
                }

                // Show success notification after validation
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Form submitted successfully!', 
                    text: 'Your reclamation has been submitted.' 
                });

                // Now submit the form after all validation passes
                document.querySelector('#reclamation-form').submit();

            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error checking email.' });
                console.error(e);
            }
        }
    });
</script>


    

</body>
</html>


























", "reclamation/new.html.twig", "C:\\Users\\Med\\Desktop\\Project_Symphony\\templates\\Reclamation\\new.html.twig");
    }
}
