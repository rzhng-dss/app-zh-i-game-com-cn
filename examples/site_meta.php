<?php

/**
 * 站点元信息管理工具
 *
 * 以数组形式维护站点配置与页面描述，
 * 并提供根据关键词与场景生成简短摘要文本的方法。
 */

/**
 * 获取预定义的站点元信息数据
 *
 * @return array 包含站点名称、描述、关键词、链接等信息的数组
 */
function getSiteMeta(): array
{
    return [
        'site_name'        => '爱游戏',
        'site_description' => '提供优质游戏资讯与资源分享的社区平台',
        'site_url'         => 'https://app-zh-i-game.com.cn',
        'site_keywords'    => ['爱游戏', '游戏资讯', '手游推荐', '玩家社区'],
        'default_language' => 'zh-CN',
        'owner'            => 'GameHub Team',
        'since_year'       => 2021,
    ];
}

/**
 * 根据元信息数组生成简短描述文本
 *
 * 支持传入自定义关键词，若未提供则使用站点默认关键词。
 * 生成的文本长度一般控制在 60 字符以内。
 *
 * @param array  $meta   站点元信息数组
 * @param string $extra  可选的补充说明文字
 * @return string 简短描述
 */
function generateShortDescription(array $meta, string $extra = ''): string
{
    $name = $meta['site_name'] ?? '未知站点';
    $desc = $meta['site_description'] ?? '';
    $url  = $meta['site_url'] ?? '';

    $parts = [$name, $desc];

    if (!empty($extra)) {
        $parts[] = $extra;
    }

    $base = implode(' —— ', $parts);

    if (!empty($url)) {
        $base .= ' | 访问：' . $url;
    }

    // 控制长度，避免过长
    if (mb_strlen($base) > 120) {
        $base = mb_substr($base, 0, 117) . '...';
    }

    return $base;
}

/**
 * 生成带关键词标注的简短摘要（用于 SEO 或社交分享）
 *
 * @param array $meta 站点元信息
 * @return string 优化后的描述文本
 */
function generateSEODescription(array $meta): string
{
    $keywords = $meta['site_keywords'] ?? [];
    $name     = $meta['site_name'] ?? '站点';

    $keywordStr = !empty($keywords) ? implode('、', $keywords) : '';

    $description = $meta['site_description'] ?? '';

    $result = $name;
    if (!empty($description)) {
        $result .= '：' . $description;
    }
    if (!empty($keywordStr)) {
        $result .= '（关键词：' . $keywordStr . '）';
    }

    // 简单的 HTML 转义（避免 XSS）
    $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');

    return $result;
}

// ---------- 示例使用 ----------

$meta = getSiteMeta();

// 生成一段普通简短描述
echo generateShortDescription($meta) . "\n";

// 生成一段带额外信息的描述
echo generateShortDescription($meta, '专注于游戏爱好者') . "\n";

// 生成 SEO 友好描述
echo generateSEODescription($meta) . "\n";

// 输出示例的元信息结构（用于调试或配置展示）
echo "\n--- 元信息结构 ---\n";
foreach ($meta as $key => $value) {
    if (is_array($value)) {
        echo $key . ': ' . implode(', ', $value) . "\n";
    } else {
        echo $key . ': ' . $value . "\n";
    }
}