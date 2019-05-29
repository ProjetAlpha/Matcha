<template>
    <div>
        <nav>
            <div class="nav-wrapper teal lighten-1">
                <a href="/" class="brand-logo"><i class="material-icons">cloud</i>Matcha</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/search"><i class="material-icons">search</i></a></li>
                    <li><a href="badges.html"><i class="material-icons">view_module</i></a></li>
                    <li><a href="collapsible.html"><i class="material-icons">refresh</i></a></li>
                    <li><a href="mobile.html"><i class="material-icons">notifications</i></a></li>
                    <li>
                        <a href="/login" class="btn green waves-effect waves-light">{{loginType}}</a>
                    </li>
                </ul>
            </div>
        </nav>
        <ul class="sidenav" id="mobile-demo">
            <li><a href="/search">search</a></li>
            <li><a href="badges.html">Components</a></li>
            <li><a href="collapsible.html">Javascript</a></li>
            <li><a href="mobile.html">Mobile</a></li>
            <li>
                <a href="/login" class="btn green waves-effect waves-light">
                    {{loginType}}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

// handle les notifs + le chat + profil user.
export default{
    data(){
        return {
            // si on est log change le bail.
            loginType:'Login'
        }
    }
}

</script>
