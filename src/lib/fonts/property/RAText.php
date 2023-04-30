<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts\property;

class RAText implements TextInterface
{
    /** @var string */
    private $text;

    /**
     * RAText constructor.
     */
    public function __construct(string $text = null)
    {
        $this->text = (string) $text;
    }

    public function setText(string $text): TextInterface
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setInitials(int $maxLetters = 2): TextInterface
    {
        $textArray = array_slice($this->wordsToArray(), 0, abs($maxLetters));
        $this->text = implode('', array_map(function ($value) {
            return mb_strtoupper($value[0]);
        }, $textArray));

        return $this;
    }

    public function __toString(): string
    {
        return $this->text;
    }

    private function wordsToArray(string $text = null): array
    {
        $text = $text ?? $this->text;
        $textArray = explode(' ', $text);
        $textArray = array_filter($textArray, function ($word) {
            return mb_strlen($word) > 1 && !preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $word);
        });

        return $textArray;
    }
}
