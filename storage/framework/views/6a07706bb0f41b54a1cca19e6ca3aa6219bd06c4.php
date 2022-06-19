<?php $dash.='-- '; ?>
<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($subcategory->id); ?>"><?php echo e($dash); ?><?php echo e($subcategory->name); ?></option>
    <?php if(count($subcategory->subcategory)): ?>
        <?php echo $__env->make('subCategoryList-option',['subcategories' => $subcategory->subcategory], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>