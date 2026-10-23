# CodeMeter — Source Code Line Counter

**A lightweight source code analysis tool built with JavaScript and PHP.**

CodeMeter counts physical lines, blank lines, comment lines, and lines of code across multiple programming languages. It features a retro-futuristic terminal interface inspired by synthwave aesthetics, with a dark theme, dotted borders, neon grid floor, and interactive file management.

**Created by [jalalkhan10061986](https://github.com/jalalkhan10061986)**

---

# Features

- **Multi-language support:** Count source code lines across approximately 60 programming languages.
- **Detailed line counting:** Separately reports physical lines, blank lines, comment lines, and code lines.
- **Interactive interface:** Dark terminal-inspired UI with synthwave grid graphics and orange accents.
- **Flexible file loading:** Open individual files, select multiple files, or load entire folders.
- **Drag and drop:** Drop a folder onto the file table to load supported source files.
- **Multiple viewing modes:** Show Files, Group by Language, and Group by Directory.
- **Sortable columns:** Click column headers or use keyboard shortcuts to sort results.
- **Summary totals:** View aggregate statistics in the `SUM:` row.
- **Automatic filtering:** Skips common dependency and version-control folders, including `node_modules` and `.git`.
- **File size protection:** Skips files larger than 1 MB.
- **Skipped-file reporting:** Displays the number of files skipped because of unsupported languages or binary content.

# Built With

- **PHP** — Server-side file processing and line-counting logic.
- **JavaScript** — Interactive interface, file selection, grouping, and sorting.
- **HTML5** — Application structure.
- **CSS3** — Dark terminal styling, synthwave grid effects, and responsive layout.

# Project Structure

```text
CodeMeter/
├── index.html    # User interface and JavaScript logic
├── count.php     # PHP line-counting endpoint
└── README.md     # Project documentation
```

# Getting Started

# Requirements

- PHP 7.4 or later recommended.
- A modern web browser.
- No database required.

# Installation

**1. Clone the repository**

```bash
git clone https://github.com/jalalkhan10061986/CodeMeter.git
```

**2. Navigate to the project directory**

```bash
cd CodeMeter
```

**3. Start the PHP development server**

```bash
php -S localhost:8000
```

**4. Open CodeMeter**

Visit the following address in your browser:

http://localhost:8000

> **Important:** Run the application through a PHP server. Opening `index.html` directly using the `file://` protocol will not work correctly because the interface communicates with `count.php`.

# How to Use

1. Launch CodeMeter in your browser.
2. Select **Open Files** to choose individual files or **Open Folder** to select a project directory.
3. Alternatively, drag and drop a folder onto the file table if your browser supports folder selection through drag and drop.
4. Review the line-counting statistics.
5. Switch between **Show Files**, **Group by Language**, and **Group by Directory** to explore your project.
6. Click column headers to sort the results, or use keyboard shortcuts.
7. Check the `SUM:` row for aggregate totals.

# Keyboard Shortcuts

| Shortcut | Action |
|---|---|
| `1`–`6` | Sort by the corresponding column |
| `Ctrl + Q` | Clear the table |

*Note: Some browsers or operating systems may reserve `Ctrl + Q` for their own actions.*

# Line Counting Explained

CodeMeter categorizes source code lines into the following types:

| Category | Description |
|---|---|
| **Physical Lines** | Total number of lines in a file, including blank, comment, and code lines. |
| **Blank Lines** | Lines containing only whitespace. |
| **Comment Lines** | Lines identified as comments according to the supported language rules. |
| **Code Lines** | Lines containing executable statements, declarations, or other source code. |

### Counting Rules

- A line containing code followed by a trailing comment is counted as a code line.
- Python docstrings are treated as comments by the current counting logic.
- Files with unrecognized extensions or detected binary content are skipped.
- Files larger than 1 MB and files inside excluded directories are not processed.

**Important:** These are scanner-based estimates, not compiler-level measurements. The categories may not always be mutually exclusive, and their totals should not be assumed to add up exactly to physical lines in every case.

# Supported Languages

CodeMeter is designed to recognize approximately 60 programming and markup languages. Support depends on the file extensions and comment syntax implemented in `count.php`.

Examples include:

- **Web development:** HTML, CSS, JavaScript, TypeScript, PHP
- **Backend development:** Python, Java, C, C++, C#, Go, Ruby, Rust
- **Framework-related files:** Vue, JSX, TSX
- **Data and configuration:** JSON, XML, YAML, TOML
- **Shell scripting:** Bash and PowerShell
- **Other languages:** SQL and additional supported source formats

The exact supported-language list depends on the implementation in the current version.

# Limitations

CodeMeter is a lightweight line scanner rather than a full language parser.

- Comment markers inside unusual string literals may be interpreted incorrectly.
- Complex, multiline strings and language-specific syntax may affect accuracy.
- Comment handling differs between programming languages.
- Python docstrings are treated as comments, which may not match every team's definition of comment lines.
- Files larger than 1 MB are skipped.
- The application has not yet been fully tested, so counting accuracy and browser compatibility remain unverified.

For these reasons, results should be treated as estimates rather than authoritative metrics for code quality or project complexity.

# Security and Privacy

CodeMeter uses PHP to process source files through its counting endpoint. Review the implementation before deploying it publicly, especially the server-side handling of uploaded or selected file content.

Run the application locally when analyzing private or confidential projects. Do not expose the development server directly to the public internet.

# Roadmap

Potential future improvements include:

- [ ] Expand language coverage and improve comment detection.
- [ ] Improve parsing of multiline strings and inline comments.
- [ ] Export reports to CSV, JSON, or Excel.
- [ ] Add project comparison and historical statistics.
- [ ] Add file filtering and extension-based search.
- [ ] Improve accessibility and mobile responsiveness.
- [ ] Add automated tests for supported language rules.

# Contributing

Contributions, bug reports, feature suggestions, and improvements are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Make your changes and test them locally.
4. Submit a pull request describing your improvements.

# License

No license has been specified yet. Add a `LICENSE` file to define how others may use, modify, and distribute CodeMeter.

# Author

**Jalal Khan**

GitHub: [@jalalkhan10061986](https://github.com/jalalkhan10061986)

Interested in PHP development, JavaScript, web applications, and developer productivity tools.

---

 If you find CodeMeter useful, consider starring the repository and sharing your feedback!

**CodeMeter — Measure Your Code. Understand Your Project.**
