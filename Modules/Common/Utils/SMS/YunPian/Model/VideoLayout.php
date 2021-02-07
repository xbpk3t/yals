<?php

namespace Modules\Common\Utils\SMS\YunPian\Model;

/**
 * @author dzh
 *
 * @since 1.0.2
 */
class VideoLayout
{
    public $vlVersion = '0.0.1'; // layout的版本号

    public $subject;

    public $frames;

    public function __toString()
    {
        return json_encode($this);
    }

    public function version($v = null, $rr = false)
    {
        if (isset($v) || $rr) {
            $this->vlVersion = $v;

            return $this;
        }

        return $this->vlVersion;
    }

    public function subject($subject = null, $rr = false)
    {
        if (isset($subject) || $rr) {
            $this->subject = $subject;

            return $this;
        }

        return $this->subject;
    }

    public function frames($frames = null, $rr = false)
    {
        if (isset($frames) || $rr) {
            $this->frames = $frames;

            return $this;
        }

        return $this->frames;
    }
}
