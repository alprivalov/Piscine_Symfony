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

/* post/index.html.twig */
class __TwigTemplate_0e124dcd4acb3b727925805a2cf881ac extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "post/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "post/index.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Hello PostController!";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class=\"example-wrapper\">
    ";
        // line 12
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 12, $this->source); })()), "user", [], "any", false, false, false, 12)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 13
            yield "        <form id=\"post-form\" action=\"";
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_post_new");
            yield "\">
            <input type=\"text\" name=\"title\">
            <input type=\"text\" name=\"content\">
            <input type=\"submit\" value=\"create\">
        </form>
    ";
        } else {
            // line 19
            yield "        ";
            yield from $this->load("user/login.html.twig", 19)->unwrap()->yield($context);
            // line 20
            yield "    ";
        }
        // line 21
        yield "
    <ul id=\"posts\">
        ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["posts"]) || array_key_exists("posts", $context) ? $context["posts"] : (function () { throw new RuntimeError('Variable "posts" does not exist.', 23, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 24
            yield "            <li id=\"li_";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "getId", [], "method", false, false, false, 24), "html", null, true);
            yield "\">
                <a href=\"#\" class=\"post-view\" id=\"";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "getId", [], "method", false, false, false, 25), "html", null, true);
            yield "\"> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "getTitle", [], "method", false, false, false, 25), "html", null, true);
            yield " </a>
                ";
            // line 26
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "getCreated", [], "any", false, false, false, 26), "Y-m-d"), "html", null, true);
            yield "
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['post'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        yield "    </ul>

    <script>
        const appUser = ";
        // line 32
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 32, $this->source); })()), "user", [], "any", false, false, false, 32)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("true") : ("false"));
        yield ";

        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById('posts').addEventListener('click', async (e) => {
                if(e.target.classList.contains('post-view')){
                    e.preventDefault();
                    const id = e.target.id;
                    const response = await fetch(`/view/\${id}`);
                    const json = await response.json();
                    const postLi = document.getElementById(`li_\${id}`);
                    const detail = json.details;
                    const existing = postLi.querySelector('.post-details');
                    if(existing) existing.remove();

                    const details = document.createElement('div');
                    details.classList.add('post-details');
                    details.innerHTML = `
                        <p>\${detail.id} \${detail.title} \${detail.content} \${detail.created}</p>

                    `;

                    if(appUser) {
                        details.innerHTML += `
                            <a href=\"#\" class=\"post-delete\" data-id=\"\${detail.id}\">delete</a>
                        `
                    }
                    postLi.appendChild(details);
                }

                if(e.target.classList.contains('post-delete')){
                    e.preventDefault();
                    const id = e.target.dataset.id;
                    if(!confirm('Want to delete?')) return;

                    const response = await fetch(`/delete/\${id}`, { method: 'POST' });
                    const json = await response.json();
                    if(json.success){
                        const li = document.getElementById(`li_\${id}`);
                        li.remove();
                    } else {
                        alert(json.message);
                    }
                }
            });

        });

        const postForm = document.getElementById('post-form');
        if(postForm){
            postForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const form = e.target;
                fetch(form.action,{
                    method:'POST',
                    body:new FormData(form)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if(!data.success){
                            alert(data.message);
                            return ;
                        }
                        const postList = document.getElementById('posts');
                        const post = document.createElement('li');
                        post.textContent += `\${ data.post.title } \${ data.post.created }`
                        postList.appendChild(post);
                        form.reset();
                    })
                })
        }
    </script>
</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "post/index.html.twig";
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
        return array (  159 => 32,  154 => 29,  145 => 26,  139 => 25,  134 => 24,  130 => 23,  126 => 21,  123 => 20,  120 => 19,  110 => 13,  108 => 12,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Hello PostController!{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class=\"example-wrapper\">
    {% if app.user %}
        <form id=\"post-form\" action=\"{{ path('app_post_new') }}\">
            <input type=\"text\" name=\"title\">
            <input type=\"text\" name=\"content\">
            <input type=\"submit\" value=\"create\">
        </form>
    {% else %}
        {% include 'user/login.html.twig' %}
    {% endif %}

    <ul id=\"posts\">
        {% for post in posts %}
            <li id=\"li_{{ post.getId() }}\">
                <a href=\"#\" class=\"post-view\" id=\"{{ post.getId() }}\"> {{ post.getTitle() }} </a>
                {{ post.getCreated | date('Y-m-d')}}
            </li>
        {% endfor %}
    </ul>

    <script>
        const appUser = {{ app.user ? 'true' : 'false' }};

        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById('posts').addEventListener('click', async (e) => {
                if(e.target.classList.contains('post-view')){
                    e.preventDefault();
                    const id = e.target.id;
                    const response = await fetch(`/view/\${id}`);
                    const json = await response.json();
                    const postLi = document.getElementById(`li_\${id}`);
                    const detail = json.details;
                    const existing = postLi.querySelector('.post-details');
                    if(existing) existing.remove();

                    const details = document.createElement('div');
                    details.classList.add('post-details');
                    details.innerHTML = `
                        <p>\${detail.id} \${detail.title} \${detail.content} \${detail.created}</p>

                    `;

                    if(appUser) {
                        details.innerHTML += `
                            <a href=\"#\" class=\"post-delete\" data-id=\"\${detail.id}\">delete</a>
                        `
                    }
                    postLi.appendChild(details);
                }

                if(e.target.classList.contains('post-delete')){
                    e.preventDefault();
                    const id = e.target.dataset.id;
                    if(!confirm('Want to delete?')) return;

                    const response = await fetch(`/delete/\${id}`, { method: 'POST' });
                    const json = await response.json();
                    if(json.success){
                        const li = document.getElementById(`li_\${id}`);
                        li.remove();
                    } else {
                        alert(json.message);
                    }
                }
            });

        });

        const postForm = document.getElementById('post-form');
        if(postForm){
            postForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const form = e.target;
                fetch(form.action,{
                    method:'POST',
                    body:new FormData(form)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if(!data.success){
                            alert(data.message);
                            return ;
                        }
                        const postList = document.getElementById('posts');
                        const post = document.createElement('li');
                        post.textContent += `\${ data.post.title } \${ data.post.created }`
                        postList.appendChild(post);
                        form.reset();
                    })
                })
        }
    </script>
</div>
{% endblock %}
", "post/index.html.twig", "/home/tontonsacha/PhpstormProjects/Piscine_Symfony/d08/templates/post/index.html.twig");
    }
}
