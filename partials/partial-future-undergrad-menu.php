<nav id="arrow-nav" class="second-nav">
    
    <?php if (get_the_title() !== 'Future Undergrads') { echo ' <a class="back" href="/students/future-students/future-undergrads/">◄ Back to Future Undergrads</a>';};?>

    <ul id="menu-secondary" class="arrow-menu">
        <li class="arrow-button arrow-1 <?php if ((get_the_title() == 'Prepare') || (get_the_title() == 'Future Student Opportunities')) { echo ' active';};?>"><a href="/students/future-students/future-undergrads/prepare/">Prepare</a></li>
        <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Connect') { echo ' active';};?>"><a href="/students/future-students/future-undergrads/connect/">Connect</a></li>
        <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Visit' || (get_the_title() == 'Future Student Visit Day')) { echo ' active';};?>"><a href="/students/future-students/future-undergrads/visit/">Visit</a></li>
        <li class="arrow-button arrow-3 <?php if (get_the_title() == 'Join Us') { echo ' active';};?>"><a href="/students/future-students/future-undergrads/join-us/">Join Us</a></li>
    </ul>

</nav><!-- #secondary-nav.side-col -->