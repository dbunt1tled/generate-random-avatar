<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts\property;

class RAText implements TextInterface
{
    /** @var string $text */
    private $text;

    /**
     * RAText constructor.
     * @param string|null $text
     */
    public function __construct(string $text = null)
    {
        $this->text = (string)$text;
    }

    /**
     * @param string $text
     * @return TextInterface
     */
    public function setText(string $text): TextInterface
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param int $maxLetters
     * @return TextInterface
     */
    public function setInitials(int $maxLetters = 2): TextInterface
    {
        $textArray = array_slice($this->wordsToArray(), 0, abs($maxLetters));
        $this->text = implode('', array_map(function ($value) {
            return mb_strtoupper($value[0]);
        }, $textArray));
        return $this;
    }

    /**
     * @param string|null $text
     * @return array
     */
    private function wordsToArray(string $text = null): array
    {
        $text = $text ?? $this->text;
        $textArray = explode(' ', $text);
        $textArray = array_filter($textArray, function ($word) {
            return mb_strlen($word) > 1 && !preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $word);
        });
        return $textArray;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->text;
    }
}
