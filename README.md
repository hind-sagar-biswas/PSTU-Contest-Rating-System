# PSTU Contest Rating System

The PSTU Contest Rating System is a rating system for online programming contests.

## Algorithm

1. **Internal True Rating**  
   - Each participant has a hidden `true_rating`, defaulting to **1400** for newcomers.

2. **Expected Rank (Seed)**  
   For each contestant A with rating \(r_A\) among \(n\) participants, compute:
   \[
     \text{seed}_A = 1 + \sum_{B\neq A} \Bigl(1 - \frac{1}{1 + 10^{(r_B - r_A)/400}}\Bigr).
   \]

3. **Performance Rating**  
   - Define the target seed:  \(\sqrt{\text{seed}_A \times p_A}\), where \(p_A\) is A’s finishing place.  
   - Find rating \(R\) in \([0,10000]\) via binary search such that computing seed with \(R\) matches the target.

4. **Rating Change (Δ)**  
   \[
     \Delta = \frac{R - r_A}{2},
   \]
   rounded to the nearest integer.

5. **Inflation Adjustment**  
   - Take the top 10% of participants (up to 30) by rating.  
   - Compute average Δ of those top players, then
   \[
     \delta_{\text{adj}} = \max\Bigl(\min\bigl(-\tfrac{\sum\Delta_{\text{top}}}{S},\,0\bigr), -10\Bigr).
   \]
   - Add \(\delta_{\text{adj}}\) to every participant’s Δ.

6. **New‑User Smoothing**  
   - Track `num_contests` per participant.  
   - For the first six contests, apply an extra “bump” offset **[500, 350, 250, 150, 100, 50]** to Δ when updating their public `display_rating`.  
   - After six contests, `display_rating` simply equals `true_rating`.

7. **Persisting Results**  
   - Save Δ to `ContestResult->delta`.  
   - Update participant’s `rating` += Δ.  
   - Update participant’s `display_rating` += Δ + bump.  
   - Increment `num_contests` by 1.

## Source

[Elo Rating](https://codeforces.com/blog/entry/102)

[Open Codeforces Rating System](https://codeforces.com/blog/entry/20762)

[Rating Calculation for New Accounts](https://codeforces.com/blog/entry/77890)
