<?php
// count.php — counts blank, comment and code lines for many languages.
// POST JSON: {"files":[{"path":"src/a.py","content":"..."}]}
header('Content-Type: application/json; charset=utf-8');

$C  = ['//'];            $CB = [['/*', '*/']];
$H  = ['#'];
$LANGS = [
  'Python'      => ['ext' => ['py','pyw','pyi'], 'line' => ['#'], 'block' => [['"""','"""'],["'''","'''"]], 'quotes' => false],
  'JavaScript'  => ['ext' => ['js','mjs','cjs'], 'line' => $C, 'block' => $CB],
  'JSX'         => ['ext' => ['jsx'], 'line' => $C, 'block' => $CB],
  'TypeScript'  => ['ext' => ['ts','mts','cts'], 'line' => $C, 'block' => $CB],
  'TSX'         => ['ext' => ['tsx'], 'line' => $C, 'block' => $CB],
  'PHP'         => ['ext' => ['php','phtml'], 'line' => ['//','#'], 'block' => $CB],
  'Java'        => ['ext' => ['java'], 'line' => $C, 'block' => $CB],
  'C'           => ['ext' => ['c'], 'line' => $C, 'block' => $CB],
  'C++'         => ['ext' => ['cpp','cc','cxx','c++'], 'line' => $C, 'block' => $CB],
  'C/C++ Header'=> ['ext' => ['h','hpp','hh','hxx'], 'line' => $C, 'block' => $CB],
  'C#'          => ['ext' => ['cs'], 'line' => $C, 'block' => $CB],
  'Objective-C' => ['ext' => ['m','mm'], 'line' => $C, 'block' => $CB],
  'Go'          => ['ext' => ['go'], 'line' => $C, 'block' => $CB],
  'Rust'        => ['ext' => ['rs'], 'line' => $C, 'block' => $CB],
  'Swift'       => ['ext' => ['swift'], 'line' => $C, 'block' => $CB],
  'Kotlin'      => ['ext' => ['kt','kts'], 'line' => $C, 'block' => $CB],
  'Scala'       => ['ext' => ['scala','sc'], 'line' => $C, 'block' => $CB],
  'Dart'        => ['ext' => ['dart'], 'line' => $C, 'block' => $CB],
  'Groovy'      => ['ext' => ['groovy','gradle'], 'line' => $C, 'block' => $CB],
  'Zig'         => ['ext' => ['zig'], 'line' => $C, 'block' => []],
  'Solidity'    => ['ext' => ['sol'], 'line' => $C, 'block' => $CB],
  'GraphQL'     => ['ext' => ['graphql','gql'], 'line' => $H, 'block' => []],
  'CSS'         => ['ext' => ['css'], 'line' => [], 'block' => $CB],
  'SCSS'        => ['ext' => ['scss'], 'line' => $C, 'block' => $CB],
  'Less'        => ['ext' => ['less'], 'line' => $C, 'block' => $CB],
  'HTML'        => ['ext' => ['html','htm'], 'line' => [], 'block' => [['<!--','-->']]],
  'XML'         => ['ext' => ['xml','svg','xsd','xsl'], 'line' => [], 'block' => [['<!--','-->']]],
  'Vue'         => ['ext' => ['vue'], 'line' => $C, 'block' => [['<!--','-->'],['/*','*/']]],
  'Svelte'      => ['ext' => ['svelte'], 'line' => $C, 'block' => [['<!--','-->'],['/*','*/']]],
  'Ruby'        => ['ext' => ['rb','rake'], 'line' => $H, 'block' => [['=begin','=end']]],
  'Perl'        => ['ext' => ['pl','pm'], 'line' => $H, 'block' => [['=pod','=cut']]],
  'Shell'       => ['ext' => ['sh','bash','zsh','ksh'], 'line' => $H, 'block' => []],
  'PowerShell'  => ['ext' => ['ps1','psm1'], 'line' => $H, 'block' => [['<#','#>']]],
  'Batch'       => ['ext' => ['bat','cmd'], 'line' => ['REM ','::'], 'block' => []],
  'Lua'         => ['ext' => ['lua'], 'line' => ['--'], 'block' => [['--[[',']]']]],
  'R'           => ['ext' => ['r'], 'line' => $H, 'block' => []],
  'Julia'       => ['ext' => ['jl'], 'line' => $H, 'block' => [['#=','=#']]],
  'SQL'         => ['ext' => ['sql'], 'line' => ['--'], 'block' => $CB],
  'Haskell'     => ['ext' => ['hs'], 'line' => ['--'], 'block' => [['{-','-}']]],
  'Elixir'      => ['ext' => ['ex','exs'], 'line' => $H, 'block' => []],
  'Erlang'      => ['ext' => ['erl','hrl'], 'line' => ['%'], 'block' => []],
  'Clojure'     => ['ext' => ['clj','cljs','cljc'], 'line' => [';'], 'block' => []],
  'Lisp'        => ['ext' => ['lisp','lsp','el','scm'], 'line' => [';'], 'block' => [['#|','|#']]],
  'OCaml'       => ['ext' => ['ml','mli'], 'line' => [], 'block' => [['(*','*)']]],
  'F#'          => ['ext' => ['fs','fsx'], 'line' => $C, 'block' => [['(*','*)']]],
  'MATLAB'      => ['ext' => ['mat'], 'line' => ['%'], 'block' => [['%{','%}']]],
  'Fortran'     => ['ext' => ['f','f90','f95','for'], 'line' => ['!'], 'block' => []],
  'Pascal'      => ['ext' => ['pas','pp'], 'line' => $C, 'block' => [['{','}'],['(*','*)']]],
  'Assembly'    => ['ext' => ['asm','s'], 'line' => [';','#'], 'block' => []],
  'Visual Basic'=> ['ext' => ['vb','bas'], 'line' => ["'"], 'block' => [], 'quotes' => false],
  'TeX'         => ['ext' => ['tex','sty'], 'line' => ['%'], 'block' => []],
  'Vim script'  => ['ext' => ['vim'], 'line' => ['"'], 'block' => [], 'quotes' => false],
  'YAML'        => ['ext' => ['yml','yaml'], 'line' => $H, 'block' => []],
  'TOML'        => ['ext' => ['toml'], 'line' => $H, 'block' => []],
  'INI'         => ['ext' => ['ini','cfg','conf'], 'line' => [';','#'], 'block' => []],
  'Makefile'    => ['ext' => ['mk','makefile'], 'line' => $H, 'block' => []],
  'Dockerfile'  => ['ext' => ['dockerfile'], 'line' => $H, 'block' => []],
  'JSON'        => ['ext' => ['json'], 'line' => [], 'block' => []],
  'Markdown'    => ['ext' => ['md','markdown'], 'line' => [], 'block' => [['<!--','-->']]],
  'Text'        => ['ext' => ['txt'], 'line' => [], 'block' => []],
];

$BY_EXT = [];
foreach ($LANGS as $name => $def) foreach ($def['ext'] as $e) $BY_EXT[$e] = $name;

function detect(string $path, array $byExt): ?string {
  $base = strtolower(basename($path));
  if ($base === 'makefile' || $base === 'gnumakefile') return 'Makefile';
  if ($base === 'dockerfile') return 'Dockerfile';
  $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
  return $byExt[$ext] ?? null;
}

function countLines(string $text, array $def): array {
  $blank = $comment = $code = 0;
  $inBlock = null; // end token while inside a block comment
  $quotes = $def['quotes'] ?? true;
  $lines = preg_split('/\R/u', $text) ?: preg_split('/\R/', $text);
  if ($lines && end($lines) === '') array_pop($lines);

  foreach ($lines as $line) {
    if (trim($line) === '') { $blank++; continue; }
    $n = strlen($line); $i = 0; $hasCode = false; $hasComment = false;
    while ($i < $n) {
      if ($inBlock !== null) {
        $hasComment = true;
        $p = strpos($line, $inBlock, $i);
        if ($p === false) break;
        $i = $p + strlen($inBlock); $inBlock = null; continue;
      }
      $ch = $line[$i];
      if ($ch === ' ' || $ch === "\t" || $ch === "\r") { $i++; continue; }
      foreach ($def['line'] as $tok) {
        if (substr_compare($line, $tok, $i, strlen($tok)) === 0) { $hasComment = true; break 2; }
      }
      foreach ($def['block'] as [$s, $e]) {
        if (substr_compare($line, $s, $i, strlen($s)) === 0) {
          $hasComment = true; $inBlock = $e; $i += strlen($s); continue 2;
        }
      }
      $hasCode = true;
      if ($quotes && ($ch === '"' || $ch === "'")) {
        $j = $i + 1;
        while ($j < $n && $line[$j] !== $ch) { if ($line[$j] === '\\') $j++; $j++; }
        $i = $j + 1; continue;
      }
      $i++;
    }
    if ($hasCode) $code++; else $comment++;
  }
  return [$blank, $comment, $code];
}

$start = microtime(true);
$in = json_decode(file_get_contents('php://input'), true);
if (!is_array($in) || !isset($in['files']) || !is_array($in['files'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Send JSON like {"files":[{"path":"a.py","content":"..."}]}']);
  exit;
}

$out = []; $skipped = 0;
foreach ($in['files'] as $f) {
  $path = (string)($f['path'] ?? ''); $content = (string)($f['content'] ?? '');
  $lang = detect($path, $BY_EXT);
  if ($lang === null || strpos($content, "\0") !== false) { $skipped++; continue; }
  [$b, $c, $k] = countLines($content, $LANGS[$lang]);
  $out[] = ['path' => $path, 'language' => $lang, 'blank' => $b, 'comment' => $c, 'code' => $k, 'total' => $b + $c + $k];
}
echo json_encode(['files' => $out, 'skipped' => $skipped, 'server_sec' => round(microtime(true) - $start, 3)]);
