<!-- Footer -->
<tr>
    <td>
        <table style="<?php echo e($style['email-footer']); ?>" align="center" width="570"
               cellpadding="0" cellspacing="0">
            <tr>
                <td style="<?php echo e($fontFamily); ?> <?php echo e($style['email-footer_cell']); ?>">
                    <p style="<?php echo e($style['paragraph-sub']); ?>">
                        &copy; <?php echo e(date('Y')); ?>

                        <a style="<?php echo e($style['anchor']); ?>" href="<?php echo e(url('/')); ?>"
                           target="_blank"><?php echo e(config('app.name')); ?></a>.
                        All rights reserved.
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>