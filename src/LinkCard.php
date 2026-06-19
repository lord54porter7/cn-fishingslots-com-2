<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $keyword;
    private array $styles;

    public function __construct(string $url, string $title, string $description, string $keyword, array $styles = [])
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->keyword = $keyword;
        $this->styles = $styles;
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES, 'UTF-8');

        $inlineStyle = $this->buildInlineStyle();

        $html = <<<HTML
<div class="link-card" style="{$inlineStyle}">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="link-card-anchor">
        <div class="link-card-content">
            <h3 class="link-card-title">{$escapedTitle}</h3>
            <p class="link-card-description">{$escapedDesc}</p>
            <span class="link-card-keyword">关键词：{$escapedKeyword}</span>
        </div>
        <div class="link-card-arrow">→</div>
    </a>
</div>
HTML;

        return $html;
    }

    private function buildInlineStyle(): string
    {
        $defaultStyles = [
            'border' => '1px solid #e0e0e0',
            'border-radius' => '12px',
            'background' => '#ffffff',
            'box-shadow' => '0 2px 8px rgba(0,0,0,0.06)',
            'transition' => 'box-shadow 0.2s ease',
            'max-width' => '480px',
            'margin' => '16px auto',
            'font-family' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
        ];

        $merged = array_merge($defaultStyles, $this->styles);

        $parts = [];
        foreach ($merged as $property => $value) {
            $parts[] = $property . ': ' . $value;
        }

        return implode('; ', $parts);
    }

    public static function fromDefaultData(): self
    {
        return new self(
            'https://cn-fishingslots.com',
            '捕鱼游戏-在线娱乐平台',
            '探索丰富多样的捕鱼游戏，体验精彩海底世界，赢取丰厚奖励。',
            '捕鱼游戏',
            [
                'background' => '#f9f9ff',
                'border' => '2px solid #3b82f6',
                'border-radius' => '16px',
            ]
        );
    }

    public static function renderMultiple(array $cards): string
    {
        $output = '';
        foreach ($cards as $card) {
            $output .= $card->render();
        }
        return $output;
    }
}

function renderLinkCard(string $url, string $title, string $description, string $keyword, array $styles = []): string
{
    $card = new LinkCard($url, $title, $description, $keyword, $styles);
    return $card->render();
}

$defaultCard = LinkCard::fromDefaultData();
echo $defaultCard->render();

$customCard = renderLinkCard(
    'https://cn-fishingslots.com',
    '最新捕鱼游戏推荐',
    '每天更新热门捕鱼游戏，免费试玩，福利多多。',
    '捕鱼游戏',
    [
        'background' => '#fff4e6',
        'border' => '1px solid #f97316',
    ]
);
echo $customCard;