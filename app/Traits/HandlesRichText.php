<?php

namespace App\Traits;

trait HandlesRichText
{
    /**
     * Create Contentful-like RichText structure from plain text
     */
    protected function createRichText(?string $text): array
    {
        if (empty($text)) return [];
        
        // Split by newlines to create multiple paragraphs
        $paragraphs = explode("\n", $text);
        $contentNodes = [];

        foreach ($paragraphs as $p) {
            if (trim($p) === '') continue;
            
            $contentNodes[] = [
                'nodeType' => 'paragraph',
                'data' => [],
                'content' => [
                    [
                        'nodeType' => 'text',
                        'value' => trim($p),
                        'marks' => [],
                        'data' => []
                    ]
                ]
            ];
        }

        return [
            'nodeType' => 'document',
            'data' => [],
            'content' => $contentNodes
        ];
    }

    /**
     * Extract plain text from RichText structure
     */
    protected function extractTextFromRichText($richText): string
    {
        if (empty($richText) || !isset($richText['content'])) return '';
        
        $text = '';
        foreach ($richText['content'] as $node) {
            if ($node['nodeType'] === 'paragraph') {
                foreach ($node['content'] as $innerNode) {
                    if ($innerNode['nodeType'] === 'text') {
                        $text .= $innerNode['value'] . "\n\n";
                    }
                }
            }
        }
        
        return trim($text);
    }
}
