<p>
The <b>evaluationss per students</b> indicates hoy many editions will evaluate each student, it's the main function of AssessMediaWiki.

<?php echo "<br><br>";?>

The <b>metaevaluations</b> are evaluations of the evaluation of an edition made by another student,
to allow metaevaluations they must be set in more than 0 and we have to define a rol for metaevaluator students,
allowing them to acces to the metaevaluations section.

<?php echo "<br><br>";?>

The amount of <b>evaluations per edition</b> indicates how many times one edition will be evaluated for several studetns
and cannot be lower than 1, each edition has to recibe at least one evaluation.

<?php echo "<br><br>";?>

The <b>minumun of editions evaluated per student</b> indicates the amount of edition that would be evaluated for eache student
(always the most significant) after that minimun it will take the most significant one that havent been selected yet, so if the minimun
is 2 we can find students with 2 editions evaluated and students with 8 editions evaluated.
<?php echo "<br>";?>
The only case in wich we will find people with less editions evaluated that the specified value is the case that the student hasn't reaced
the minimun number of editions (students with one edition for example).

<?php echo "<br><br>";?>

The <b>autoevaluation</b> allos students to evaluate their own editions, the only avalible values are 0 (off) and 1 (on).

<?php echo "<br><br>";?>

Students for the evaluations of the <b>evaluation exercises</b> will be selected automatically, the only requisite is to
have done any aportation to the wiki in the <b>develop phase</b>. If some student doesnt make any change during the
<b>develop phase</b>, it would be impposible to assign her/him any edition of another student to evaluate it.

<?php echo "<br><br>";?>

<h2>Important</h2> <b></b>

If we configure two <b>evaluation exercises</b> in wich the <b>develop phase</b> has days in common for both
the editions of those days will be evaluated in both exercises, they won't be differenced.

<?php echo "<br><br>";?>

We can find cases in wich some editions have been evaluated twice by the same student, the chances of this event
increases with a large amount of <b>evaluations per edition</b>, with a low ammount is inusual but not impossible

<?php echo "<br><br>";?>

If the number of <b>evaluations per edition</b> is not divisor of the number of <b>evaluations per student</b>
it will generate some editions with less evaluations than expected in order to no generate more <b>evaluations per student</b>
than the setted in the configuration.
<?php echo "<br>";?>
Example: if we define 10 <b>evaluations per student</b> and 3 <b>evaluations per edition</b> due to the algorithm selected
it will cause that some editions get only 1 evaluation (10-3*n, in this case n=3), but we will never make students to do more than 10 evaluations.
<?php echo "<br>";?>
Recomended configuration:
<?php echo "<br>";?>
For 8 <b>evaluations per student</b> 2 or 4 <b>evaluations per edition</b>.
<?php echo "<br>";?>
For 9 <b>evaluations per student</b> 3 <b>evaluations per edition</b>. <- Optimal, 90% grade = evaluations recived, 10% grade = evaluations made.
<?php echo "<br>";?>
For 10 <b>evaluations per student</b> 2 <b>evaluations per edition</b>.
<?php echo "<br>";?>
For 15 <b>evaluations per student</b> 3 <b>evaluations per edition</b>.
<?php echo "<br>";?>
And so on...

<?php echo "<br><br>";?>

It's not possible to define more <b>evaluations per edition</b> than the <b>minumun of editions evaluated per student</b> multiplicated
per the ammount of <b></b>

<?php echo "<br><br>";?>

</p>