
<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td><?php echo e($_SESSION['i']); ?></td>
        <td><?php echo e($dash); ?><?php echo e($subcategory->name); ?></td>
        <td><?php echo e($subcategory->slug); ?></td>
        <td><?php echo e($subcategory->parent->name); ?></td>
    </tr>
    <?php if(count($subcategory->subcategory)): ?>
        <?php echo $__env->make('sub-category-list',['subcategories' => $subcategory->subcategory], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>