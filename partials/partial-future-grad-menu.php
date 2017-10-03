<nav id="arrow-nav" class="second-nav">
    
    <?php if (get_the_title() !== 'Future Graduate Students') { echo ' <a class="back" href="/students/future-students/future-graduate-students/">◄ Back to Future Graduate Students</a>';};?>

    <ul id="menu-secondary" class="arrow-menu">
        <li class="arrow-button arrow-1 <?php if ((get_the_title() == 'Prepare') || (get_the_title() == 'FAQs')) { echo ' active';};?>"><a href="/students/future-students/future-graduate-students/prepare/">Prepare</a></li>
        <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Connect') { echo ' active';};?>"><a href="/students/future-students/future-graduate-students/connect/">Connect</a></li>
        <li class="arrow-button arrow-2 <?php if (get_the_title() == 'Visit' || (get_the_title() == 'Future Student Visit Day')) { echo ' active';};?>"><a href="/students/future-students/future-graduate-students/visit/">Visit</a></li>
        <li class="arrow-button arrow-3 <?php if (get_the_title() == 'Join Us') { echo ' active';};?>"><a href="/students/future-students/future-graduate-students/join-us/">Join Us</a></li>
    </ul>

</nav><!-- #secondary-nav.side-col -->