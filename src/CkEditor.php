<?php

namespace BayAreaWebPro\NovaFieldCkEditor;

use Laravel\Nova\Fields\Expandable;
use Laravel\Nova\Fields\Field;

class CkEditor extends Field
{
    use Expandable;

    /**
     * The field's component.
     * @var string $component
     */
    public $component = 'ckeditor';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->toolbar = config('nova-ckeditor.default_ck_toolbar',
            ['bold', 'italic', 'strikethrough', 'underline']);

        $this->codeBlock = config('nova-ckeditor.default_ck_code_block',
            [['language' => 'plaintext', 'label' => 'Plain Text']]);
    }

    /**
     * Indicates whether the media browser should be available.
     * @var bool $mediaBrowser
     */
    public bool $mediaBrowser = false;

    /**
     * Specifies the editor default height in pixels.
     * @var int $height
     */
    public int $height = 300;

    /**
     * Specifies the available toolbar items.
     * @var array $toolbar
     */
    public array $toolbar = [];

    /**
     * Specifies the available code styles in the code block.
     * @var array $codeBlock
     */
    public array $codeBlock = [];

    /**
     * Indicates whether the link browser should be available.
     * @var bool $linkBrowser
     */
    public bool $linkBrowser = false;

    /**
     * The snippets to be displayed in the snippet browser.
     * @var array
     */
    public array $snippetBrowser = [];

    /**
     * Set the toolbar item layout.
     * @param array $items
     * @return $this
     */
    public function toolbar(array $items): self
    {
        $this->toolbar = $items;
        return $this;
    }

    /**
     * Set the code styles item layout.
     * @param array $items
     * @return $this
     */
    public function codeBlock(array $items): self
    {
        $this->codeBlock = $items;
        return $this;
    }

    /**
     * Set the editor height.
     * @param int $pixels
     * @return $this
     */
    public function height(int $pixels): self
    {
        $this->height = $pixels;
        return $this;
    }

    /**
     * Enable Media Browser.
     * @param bool $enabled
     * @return $this
     */
    public function mediaBrowser(bool $enabled = true): self
    {
        $this->mediaBrowser = $enabled;
        return $this;
    }

    /**
     * Enable Link Browser.
     * @param bool $enabled
     * @return $this
     */
    public function linkBrowser(bool $enabled = true): self
    {
        $this->linkBrowser = $enabled;
        return $this;
    }

    /**
     * Enable Snippets Browser.
     * @param array $snippets
     * @return $this
     */
    public function snippets(array $snippets): self
    {
        $this->snippetBrowser = $snippets;
        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'snippetBrowser' => $this->snippetBrowser,
            'mediaBrowser' => $this->mediaBrowser,
            'linkBrowser' => $this->linkBrowser,
            'toolbar' => $this->toolbar,
            'codeBlock' => $this->codeBlock,
            'height' => $this->height,
            'shouldShow' => $this->shouldBeExpanded(),
        ]);
    }
}
