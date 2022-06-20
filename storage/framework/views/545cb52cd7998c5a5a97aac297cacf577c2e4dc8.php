<?php $dash.='-- '; ?>
<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td><?php echo e($_SESSION['i']); ?></td>
        <td><?php echo e($dash); ?><?php echo e($subcategory->name); ?></td>
        <td><?php echo e($subcategory->slug); ?></td>
        <td>
            <?php if(isset($subcategory->parentCategory)): ?>
                <?php echo e($subcategory->parentCategory->name); ?>

            <?php else: ?>
                None
            <?php endif; ?>
        </td>
        <td class="text-center hidden-print">
            <div class="btn-group">
                <button type="button"
                    class="btn btn-default"><?php echo e(trans('file.Action')); ?></button>
                <button type="button" class="btn btn-default dropdown-toggle"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                    <li><a class="edit-category" data-toggle="modal"
                            data-target="#exampleModal" data-id="<?php echo e($subcategory->id); ?>"
                            data-name="<?php echo e($subcategory->name); ?>"
                            data-slug="<?php echo e($subcategory->slug); ?>"
                            data-parent="<?php echo e($subcategory->parent); ?>"><i class="fa fa-pencil"
                                aria-hidden="true"></i> <?php echo e(trans('file.Edit')); ?></a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo e(route('document.create')); ?>?filter_category_id=<?php echo e($subcategory->id); ?>"><i class="fa fa-eye"
                        aria-hidden="true"></i> <?php echo e(trans('file.Vew Documents')); ?></a></li>
                    <li class="divider"></li>
                    <li>
                        <a>
                            <form method="post" action="<?php echo e(route('category.delete')); ?>">
                                <?php echo csrf_field(); ?>

                                <input type="hidden" name="category_id"
                                    value="<?php echo e($category->id); ?>">
                                <button type="submit"
                                    style="display: block; background:none;border:none"><i
                                        class="fa fa-trash" aria-hidden="true"></i>
                                    <?php echo e(trans('file.Delete')); ?></button>
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    <?php if(count($subcategory->subcategory)): ?>
        <?php echo $__env->make('categories.subcategory',['subcategories' => $subcategory->subcategory], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>