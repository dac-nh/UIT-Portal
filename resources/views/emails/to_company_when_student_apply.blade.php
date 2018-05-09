@extends('emails.layouts.email_master')
@section('email_content')
    <!-- Email Body -->
    <tr>
        <td style="<?php echo e($style['email-body']); ?>" width="100%">
            <table style="<?php echo e($style['email-body_inner']); ?>" align="center" width="570"
                   cellpadding="0" cellspacing="0">
                <tr>
                    <td style="<?php echo e($fontFamily); ?> <?php echo e($style['email-body_cell']); ?>">
                        <!-- Greeting -->
                        <h1 style="<?php echo e($style['header-1']); ?>">
                            <?php if (!empty($greeting)): ?>
                                                <?php echo e($greeting); ?>
                                        <?php endif; ?>
                        </h1>

                        <!-- Intro -->
                        <?php if (!empty($introLines)):?>
                        <?php $__currentLoopData = $introLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <p style="<?php echo e($style['paragraph']); ?>">
                            <?php echo e($line); ?>

                        </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        <?php endif; ?>

                    <!-- Action Button -->
                        <?php if(isset($actionText)): ?>
                        <table style="<?php echo e($style['body_action']); ?>" align="center" width="100%"
                               cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <?php
                                    if (isset($level)) {
                                        switch ($level) {
                                            case 'success':
                                                $actionColor = 'button--green';
                                                break;
                                            case 'error':
                                                $actionColor = 'button--red';
                                                break;
                                            default:
                                                $actionColor = 'button--blue';
                                        }
                                    } else {
                                        $actionColor = 'button--blue';
                                    }
                                    ?>

                                    <a href="<?php echo e($actionUrl); ?>"
                                       style="<?php echo e($fontFamily); ?> <?php echo e($style['button']); ?> <?php echo e($style[$actionColor]); ?>"
                                       class="button"
                                       target="_blank">
                                        <?php echo e($actionText); ?>

                                    </a>
                                </td>
                            </tr>
                        </table>
                        <?php endif; ?>

                    <!-- Outro -->
                        <?php if (!empty($outroLines)):?>
                        <?php $__currentLoopData = $outroLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <p style="<?php echo e($style['paragraph']); ?>">
                            <?php echo e($line); ?>

                        </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        <?php endif; ?>

                    <!-- Salutation -->
                        <p style="<?php echo e($style['paragraph']); ?>">
                            Xin cảm ơn,<br><?php echo e(config('app.name')); ?>

                        </p>

                        <!-- Sub Copy -->
                        <?php if(isset($actionText)): ?>
                        <table style="<?php echo e($style['body_sub']); ?>">
                            <tr>
                                <td style="<?php echo e($fontFamily); ?>">
                                    <p style="<?php echo e($style['paragraph-sub']); ?>">
                                        Nếu có bất cứ lỗi gì khi click vào nút
                                        "<?php echo e($actionText); ?>",
                                        hãy sao chép và dán trực tiếp vào đường dẫn web để thực hiện thao
                                        tác:
                                    </p>

                                    <p style="<?php echo e($style['paragraph-sub']); ?>">
                                        <a style="<?php echo e($style['anchor']); ?>"
                                           href="<?php echo e($actionUrl); ?>" target="_blank">
                                            <?php echo e($actionUrl); ?>

                                        </a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection