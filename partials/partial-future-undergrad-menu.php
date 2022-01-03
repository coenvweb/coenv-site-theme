<nav id="arrow-nav" class="second-nav">
    
    <?php if (preg_match('/(Future Undergrads)/', get_the_title())) { ?>
        <ul id="menu-secondary" class="arrow-menu">
            <li class="arrow-button arrow-1 <?php if ((get_the_title() == 'Prepare') || (get_the_title() == 'Future Student Opportunities')) { echo ' active';};?>"><a href="/students/future-undergrads/prepare/">Prepare<br/><span class="future-subtext">Degrees and prerequisites</span></a></li>
            <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Connect') { echo ' active';};?>"><a href="/students/future-undergrads/connect/">Connect<br/><span class="future-subtext">Meet advisers and students</span></a></li>
            <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Visit' || (get_the_title() == 'Future Student Visit Day')) { echo ' active';};?>"><a href="/students/future-undergrads/visit/">Visit<br/><span class="future-subtext">Virtual and on-campus events</span></a></li>
            <li class="arrow-button arrow-3 <?php if (get_the_title() == 'Apply') { echo ' active';};?>"><a href="/students/future-undergrads/apply/">Apply<br/><span class="future-subtext">Admissions and scholarships</span></a></li>
        </ul>
    <?php } else { ?>
        <a class="back" href="/students/future-undergrads/">◄ Back to Future Undergrads</a>
        <ul id="menu-secondary" class="arrow-menu">
            <li class="arrow-button arrow-1 <?php if ((get_the_title() == 'Prepare') || (get_the_title() == 'Future Student Opportunities')) { echo ' active';};?>"><a href="/students/future-undergrads/prepare/">Prepare</a></li>
            <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Connect') { echo ' active';};?>"><a href="/students/future-undergrads/connect/">Connect</a></li>
            <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Visit' || (get_the_title() == 'Future Student Visit Day')) { echo ' active';};?>"><a href="/students/future-undergrads/visit/">Visit</a></li>
            <li class="arrow-button arrow-3 <?php if (get_the_title() == 'Apply') { echo ' active';};?>"><a href="/students/future-undergrads/apply/">Apply</a></li>
        </ul>
    <?php }; ?>

</nav><!-- #secondary-nav.side-col -->