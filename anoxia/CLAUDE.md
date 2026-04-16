## graphify

Two knowledge graphs exist:
- `app/graphify-out/` — **use this one** (208 nodes, 167 edges; app code only, excludes vendor)
- `graphify-out/` — full project including vendor (16K nodes; too noisy for most queries)

Rules:
- Before answering architecture or codebase questions, read `app/graphify-out/GRAPH_REPORT.md` for god nodes and community structure
- If `app/graphify-out/wiki/index.md` exists, navigate it instead of reading raw files
- After modifying code files in this session, run `graphify update app/` to keep the graph current (AST-only, no API cost)
