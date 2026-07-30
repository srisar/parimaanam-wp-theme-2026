# Homepage hero redesign

Date: 2026-07-30
Status: approved, not yet implemented
Supersedes: the hero built in `patterns/home-hero.php`

## Problem

The editor's objection was that the hero is "too static" and "not properly
done". Reading it, those are two faults rather than one.

**It cannot be art-directed.** Three queries slice the archive by hardcoded
position — `offset` 0 for the lead, 1–5 for the index, 6–7 for support. The
lead is mechanically whatever was published most recently, so the front page
reports a timestamp rather than a judgement. The offsets are positional, so
every publication silently re-slices all three regions. Core's `sticky`
support exists for exactly this and the theme sets `"sticky": ""`.

A smaller fault falls out of that: the index is headed **புதிய கட்டுரைகள்**
("new articles") but begins at article *two*, because article one has been
taken by the lead.

**It is one fixed arrangement.** A text column, a large image and two cards,
in the same proportions on every visit, whatever has been published.

## Approved decisions

1. **No rotation.** A carousel would move but would not help: readers rarely
   reach the second slide, auto-advance competes with reading, and it hides
   the publication's own work behind a timer. Life comes from composition.
2. **Sticky posts** carry editorial control. Native, already in the post
   editor, currently unused, and invisible to the taxonomy — the 22
   categories drive navigation, sidebar and footer, and a workflow category
   would surface in all three.
3. **A three-slot featured composition**, fixed in shape.

### A claim withdrawn during design

While proposing this I said overlaying the title on the photograph is "the
least readable arrangement" for Tamil. Measurement does not support it here:
the scrim reaches `0.97` opacity where the text sits, so the title is
effectively on solid ground and measures `rgb(243, 239, 238)` against a
near-opaque dark field. The overlay stays.

## Composition

```
desktop >=64rem                    tablet 40-64rem        phone <40rem
+------------------+ +--------+    +-----------------+    +--------+
|                  | | LEAD B |    |     LEAD A      |    | LEAD A |
|      LEAD A      | +--------+    +-----------------+    +--------+
|  overlay + chips | | LEAD C |    +--------+ +------+    | LEAD B |
+------------------+ +--------+    | LEAD B | |LEAD C|    +--------+
+------+ +------+ +------+         +--------+ +------+    | LEAD C |
|recent| |recent| |recent|         +------+ +------+      +--------+
+------+ +------+ +------+         |recent| |recent|       …stacked
```

- **Lead A** — two thirds width, tall, featured image with the chip pair and
  title overlaid, plus an excerpt.
- **Leads B and C** — stacked in the remaining third, image above text on
  page ground, chip pair and title, no excerpt.
- **Recent row** — three cards in the shared card language.

The five-item text-only index is removed. It was a wall of text beside the
images, and three cards do its work better.

## Slot filling

The shape never changes; only which stories occupy it.

Sticky posts fill the three featured slots in order. Any slot the editor has
not filled takes the next most recent non-sticky post. Ticking nothing
behaves exactly like today, newest first; ticking three art-directs the whole
hero. There is no state in which the hero renders a hole.

Let `N` be the number of sticky posts and `fillers = max(0, 3 - N)`.

| Region | Query |
|---|---|
| Featured slot `i` where `i < N` | `sticky: "only"`, `perPage: 1`, `offset: i` |
| Featured slot `i` where `i >= N` | `sticky: "exclude"`, `perPage: 1`, `offset: i - N` |
| Recent row | `sticky: "ignore"`, `exclude: [first three sticky IDs]`, `perPage: 3`, `offset: fillers` |

The recent row's `offset` skips exactly the posts the filler slots consumed,
and its `exclude` removes the featured three. Using `ignore` rather than
`exclude` for its sticky handling is deliberate: `exclude` would bar *every*
sticky post from the recent row, so an editor who marked five would find the
fourth and fifth removed from the homepage altogether. With `ignore` they are
merely not featured, and take their normal place by date — which for a post
old enough to be worth featuring usually means they do not appear, but they
are not banned.

These offsets are computed in PHP from `get_option( 'sticky_posts' )` at
render time. That is the opposite of the hardcoded offsets being removed —
they describe the site's actual state rather than assuming it.

### Why not select posts by ID

The obvious implementation is to resolve three IDs and hand each to a Query
block. Core does not allow it: `build_query_vars_from_query_block()` maps
`post__in` only from `sticky: "only"`, and the `include` key it accepts
belongs to `taxQuery`, for terms. There is no supported way to restrict a
Query block to arbitrary post IDs, so position is the only lever available and
the offsets above are computed to make it exact.

`sticky: "only"` is also safe when nothing is sticky: Core substitutes
`post__in = array( 0 )` rather than an empty array, which returns no posts
instead of every post. The `fillers` arithmetic means that path is never
taken anyway, but it is worth knowing the failure mode is empty and not
unbounded.

### Do not verify this with `get_posts()`

`get_posts()` special-cases `include`: it overrides `numberposts` and ignores
`offset` entirely. A check written with it reports duplicates in every state
from two sticky posts upward, which are artefacts of the wrapper and not of
this design. The Query block builds `post__in` on `WP_Query` directly, where
`offset` applies normally. Verify with `WP_Query`.

The arithmetic above was confirmed against the running site for `N` of 0, 1,
2, 3 and 5, with sticky posts taken from 200 entries deep in the archive so
promotion is actually visible: every featured post appears in its slot, and
no post appears twice in any state.

## Out of scope

- Any change to the category sections below the hero.
- Motion of any kind beyond the existing hover treatments.
- A featured taxonomy.

## Verification

No test harness; measured against the running site.

- With 0 sticky posts, the three featured slots show the three newest posts
  and the recent row shows the next three, with no repetition anywhere.
- With 1 and with 2 sticky posts, the featured slots lead with them and fill
  the remainder from recent, still with no repetition.
- With 3 sticky posts, the featured slots match them exactly.
- With 5 sticky posts, the fourth and fifth appear in the recent row.
- No post appears twice on the homepage in any of those states.
- The layout holds at 1280, 768 and 375 with no horizontal overflow, in both
  colour schemes.
