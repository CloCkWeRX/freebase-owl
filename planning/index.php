<?php
require_once 'global.php';

$application = new Application();
$property = new Property();
$address = new Address();
?>
<h1>Planning Software</h1>
<p>Read your council's planning guidelines. Start a development application online. See all development applications (pending, approved, rejected)</p>


<h2><?php print $application->renderName(); ?></h2>
<p>Here's a development application for <?php print $application->property->address->toString(); ?> by <?php print $application->applicant->toString(); ?>.</p>

<p>The current status is <strong><?php print $application->getStatus(); ?></strong></p>
<table>
    <tr>
        <th>Title</th>
        <td><?php print $application->property->title->toString(); ?></td>
        <th>Address</th>
        <td><?php print $application->property->address->toString(); ?></td>
    </tr>
    <tr>
        <th>Owner</th>
        <td><?php print $application->property->owner->toString(); ?></td>
    </tr>
    <tr>
        <th>Proposed development</th>
        <td><?php print $application->getProposedDevelopment(); ?></td>
    </tr>
    <tr>
        <th>Existing property</th>
        <td><?php print $application->getExistingProperty(); ?></td>

    </tr>
    <tr>
        <th>Approximate Cost</th>
        <td><?php print number_format($application->getApproximateCost(), 2); ?></td>
        <th>Approximate Completion Date</th>
        <td><?php print date("jS M Y", $application->getApproximateDate()); ?></td>
    </tr>
</table>